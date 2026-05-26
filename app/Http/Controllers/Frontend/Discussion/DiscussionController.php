<?php

namespace App\Http\Controllers\Frontend\Discussion;

use App\Http\Controllers\Controller;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
    public function index(Request $request)
    {
        $instructor = Auth::user();

        $courseIds = $instructor->courses()->pluck('id');
        $query = Discussion::with(['user', 'course', 'lesson', 'replies.user'])->whereIn('course_id', $courseIds)->latest();

        // Filter by course
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Filter by status: unanswered only
        if ($request->filter === 'unanswered') {
            $query->doesntHave('replies');
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                    ->orWhere('message', 'like', '%'.$request->search.'%');
            });
        }

        $discussions = $query->paginate(15)->withQueryString();

        // Unanswered count for badge
        $unansweredCount = Discussion::whereIn('course_id', $courseIds)->doesntHave('replies')->count();

        // Instructor's courses for filter dropdown
        $courses = $instructor->courses()->select('id', 'title')->get();

        return view('frontend.pages.instructor.discussions', compact(
            'discussions',
            'unansweredCount',
            'courses'
        ));
    }

    /**
     * Store instructor reply to a discussion.
     */
    public function instructorReply(Request $request)
    {
        $request->validate([
            'discussion_id' => 'required|exists:discussions,id',
            'message' => 'required|string|max:2000',
        ]);

        $discussion = Discussion::with('course')->findOrFail($request->discussion_id);

        // Make sure instructor owns the course
        $this->authorizeInstructor($discussion);

        DiscussionReply::create([
            'discussion_id' => $discussion->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return back()->with('success', 'Reply posted successfully.');
    }

    /**
     * Delete a reply (only instructor's own replies).
     */
    public function deleteReply(DiscussionReply $reply)
    {
        if ($reply->user_id !== Auth::id()) {
            abort(403);
        }

        $reply->delete();

        return back()->with('success', 'Reply deleted.');
    }

    private function authorizeInstructor(Discussion $discussion): void
    {
        $owns = Auth::user()
            ->courses()
            ->where('id', $discussion->course_id)
            ->exists();

        if (! $owns) {
            abort(403, 'You do not own this course.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Discussion::create([
            'course_id' => $request->course_id,
            'lesson_id' => $request->lesson_id,
            'user_id' => auth()->id(),
            'title' => $request->title,
            'message' => $request->message,
        ]);

        return back();
    }

    public function reply(Request $request)
    {
        $request->validate([
            'discussion_id' => 'required',
            'message' => 'required',
        ]);

        DiscussionReply::create([
            'discussion_id' => $request->discussion_id,
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return back();
    }
}
