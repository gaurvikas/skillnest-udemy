<x-layouts.app>

    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ __('Lesson Details') }}
            </h1>
        </div>

        <a href="{{ route('admin.lessons.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 text-sm font-medium rounded-md">
            &larr; {{ __('Back to Lessons') }}
        </a>
    </div>

    <!-- Center Wrapper -->
    <div class="flex justify-center">
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6 w-full max-w-md">

            <div class="space-y-4">

                <!-- Course -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">{{ __('Course') }}</span>
                    <span class="text-gray-800 text-end dark:text-gray-100">{{ $lesson->course->title ?? '-' }}</span>
                </div>

                <!-- Title -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">{{ __('Title') }}</span>
                    <span class="text-gray-800 dark:text-gray-100">{{ $lesson->title }}</span>
                </div>

                <!-- Video -->
                <div class="flex flex-col gap-2">
                    <span class="font-medium text-gray-600 dark:text-gray-400">{{ __('Video') }}</span>
                    @if ($lesson->getFirstMediaUrl('video'))
                        <video controls class="w-full rounded border border-gray-300 dark:border-gray-600">
                            <source src="{{ $lesson->getFirstMediaUrl('video') }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <span class="text-gray-500 text-sm">No Video Uploaded</span>
                    @endif
                </div>

                <!-- Content -->
                <div>
                    <span class="font-medium text-gray-600 dark:text-gray-400">{{ __('Content') }}</span>
                    <p class="text-gray-800 dark:text-gray-100 mt-1">{{ $lesson->content }}</p>
                </div>

                <!-- Duration -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">{{ __('Duration') }}</span>
                    <span class="text-gray-800 dark:text-gray-100">{{ $lesson->duration }} min</span>
                </div>

                <!-- Order -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">{{ __('Order') }}</span>
                    <span class="text-gray-800 dark:text-gray-100">{{ $lesson->order }}</span>
                </div>

                <!-- Is Preview -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">{{ __('Is Preview') }}</span>
                    <span class="text-gray-800 dark:text-gray-100">
                        {{ App\Models\Lesson::PREVIEW_OPTIONS[$lesson->is_preview] ?? '-' }}
                    </span>
                </div>

            </div>

            <!-- Actions -->
            <div class="mt-6 flex justify-center space-x-2">

                <a href="{{ route('admin.lessons.edit', $lesson) }}"
                    class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-md">
                    {{ __('Edit') }}
                </a>

                <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST"
                    onsubmit="return confirm('{{ __('Are you sure?') }}')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-md">
                        {{ __('Delete') }}
                    </button>

                </form>

            </div>

        </div>
    </div>

</x-layouts.app>
