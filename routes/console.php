<?php

use App\Jobs\ProcessInstructorTransfers;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new ProcessInstructorTransfers)
    // ->dailyAt('00:00')
    ->everyMinute()
    ->name('process-instructor-transfers')
    ->withoutOverlapping()
    ->onFailure(function () {
        Log::error('ProcessInstructorTransfers scheduler failed!');
    });
