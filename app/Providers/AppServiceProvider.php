<?php

namespace App\Providers;

use App\Listeners\ExtractVideoDuration;
use App\Models\Discussion;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAddedEvent;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Event::listen(
            MediaHasBeenAddedEvent::class,
            ExtractVideoDuration::class,
        );

        View::composer('frontend.pages.instructor.layout', function ($view) {

            if (auth()->check()) {

                $unansweredDiscussions = Discussion::whereHas('course', function ($q) {
                    $q->where('instructor_id', auth()->id());
                })
                    ->doesntHave('replies')
                    ->count();

                $view->with('unansweredDiscussions', $unansweredDiscussions);
            }
        });
    }
}
