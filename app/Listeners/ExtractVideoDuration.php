<?php

namespace App\Listeners;

use App\Models\Lesson;
use FFMpeg\FFProbe;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAddedEvent;

class ExtractVideoDuration implements ShouldQueue
{
    public function handle(MediaHasBeenAddedEvent $event): void
    {
        $media = $event->media;

        if (! ($media->model instanceof Lesson)) {
            return;
        }

        try {
            $path = $media->getPath();

            $ffprobe = FFProbe::create([
                'ffprobe.binaries' => config('laravel-ffmpeg.ffprobe.binaries'),
            ]);

            $duration = $ffprobe
                ->format($path)
                ->get('duration');

            $media->model->update([
                'duration' => (int) round($duration),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to extract video duration', [
                'lesson_id' => $media->model->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
