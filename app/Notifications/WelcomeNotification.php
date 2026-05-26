<?php

namespace App\Notifications;

use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $userName;

    protected string $exploreUrl;

    public function __construct(string $userName, string $exploreUrl)
    {
        $this->userName = $userName;
        $this->exploreUrl = $exploreUrl;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $stats = [
            'total_courses' => Course::published()->count(),
            'total_learners' => Enrollment::distinct('user_id')->count('user_id'),
            'total_instructors' => Course::distinct('instructor_id')->count('instructor_id'),
        ];

        $categories = Category::withCount('courses')
            ->orderByDesc('courses_count')
            ->limit(10)
            ->get(['id', 'name', 'icon']);

        return (new MailMessage)
            ->subject('Welcome to SkillNest!')
            ->view('frontend.pages.mail.welcome', [
                'user_name' => $this->userName,
                'explore_url' => $this->exploreUrl,
                'stats' => $stats,
                'categories' => $categories,
            ]);
    }
}
