<?php

namespace App\Notifications;

use App\Models\Certificate;
use App\Models\Enrollment;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourseCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public $course) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        // Enrollment fetch — enrolled_at aur completed_at
        $enrollment = Enrollment::where('user_id', $notifiable->id)
            ->where('course_id', $this->course->id)
            ->first();

        // Certificate fetch
        $certificate = Certificate::where('user_id', $notifiable->id)
            ->where('course_id', $this->course->id)
            ->first();

        // Dates
        $enrolledAt = $enrollment?->enrolled_at
            ? Carbon::parse($enrollment->enrolled_at)->format('d M Y')
            : now()->format('d M Y');

        $completedAt = $enrollment?->completed_at
            ? Carbon::parse($enrollment->completed_at)->format('d M Y')
            : now()->format('d M Y');

        $daysTaken = $enrollment?->enrolled_at && $enrollment?->completed_at
            ? Carbon::parse($enrollment->enrolled_at)
                ->diffInDays(Carbon::parse($enrollment->completed_at))
            : 0;

        // Course total duration (seconds → hours/mins)
        $totalSeconds = $this->course->lessons()->sum('duration') ?? 0;
        $totalDurationHours = floor($totalSeconds / 3600);
        $totalDurationMins = floor(($totalSeconds % 3600) / 60);

        // Total lessons count
        $totalLessons = $this->course->lessons()->count();

        return (new MailMessage)
            ->subject('🏆 You completed "'.$this->course->title.'"!')
            ->view('frontend.pages.mail.courseComplete', [
                'user_name' => $notifiable->name,
                'course' => $this->course->loadMissing('instructor'),
                'enrolled_at' => $enrolledAt,
                'completed_at' => $completedAt,
                'days_taken' => $daysTaken,
                'total_lessons' => $totalLessons,
                'total_duration_hours' => $totalDurationHours,
                'total_duration_mins' => $totalDurationMins,
                'certificate_number' => $certificate?->certificate_number,
                'certificate_url' => route('certificate.show', $this->course->slug),
                'review_url' => route('courses.show', $this->course->slug).'#reviews',
                'my_learning_url' => route('my-learning.index'),
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Course Completed!',
            'message' => 'Congratulations on completing a course',
        ];
    }

    /**
     * Get the notification's database type.
     */
    public function databaseType(object $notifiable): string
    {
        return 'course-complete';
    }

    /**
     * Get the initial value for the "read_at" column.
     */
    public function initialDatabaseReadAtValue(): ?Carbon
    {
        return null;
    }
}
