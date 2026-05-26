<x-layouts.app>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ __('Course Details') }}
            </h1>
        </div>

        <a href="{{ route('admin.courses.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 text-sm font-medium rounded-md">
            &larr; {{ __('Back to Courses') }}
        </a>
    </div>

    <!-- Center wrapper -->
    <div class="flex justify-center">
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 w-full max-w-md">

            <div class="space-y-4">

                <!-- Instructor -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">
                        {{ __('Instructor') }}
                    </span>

                    <span class="text-gray-800 dark:text-gray-100">
                        {{ $course->instructor->name ?? '-' }}
                    </span>
                </div>

                <!-- Title -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">
                        {{ __('Title') }}
                    </span>

                    <span class="text-gray-800 text-end dark:text-gray-100">
                        {{ $course->title }}
                    </span>
                </div>

                <!-- Description -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">
                        {{ __('Description') }}
                    </span>

                    <span class="text-gray-800 dark:text-gray-100 text-right max-w-[60%]">
                        {{ $course->description }}
                    </span>
                </div>

                <!-- Price -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">
                        {{ __('Price') }}
                    </span>

                    <span class="text-gray-800 dark:text-gray-100">
                        $ {{ number_format($course->price, 2) }}
                    </span>
                </div>

                <!-- Level -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">
                        {{ __('Level') }}
                    </span>

                    <span class="text-gray-800 dark:text-gray-100">
                        {{ App\Models\Course::LEVEL_OPTIONS[$course->level] ?? '-' }}
                    </span>
                </div>

                <!-- Status -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">
                        {{ __('Status') }}
                    </span>

                    <span class="text-gray-800 dark:text-gray-100">
                        {{ App\Models\Course::STATUS_OPTIONS[$course->status] ?? '-' }}
                    </span>
                </div>

                <!-- Duration -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">
                        {{ __('Duration') }}
                    </span>

                    <span class="text-gray-800 dark:text-gray-100">
                        {{ $course->duration }} min
                    </span>
                </div>

                <!-- Thumbnail -->
                <div class="flex justify-between items-center">
                    <span class="font-medium text-gray-600 dark:text-gray-400">
                        {{ __('Thumbnail') }}
                    </span>

                    @if ($course->getFirstMediaUrl('thumbnail'))
                        <img src="{{ $course->getFirstMediaUrl('thumbnail') }}"
                            class="w-20 h-12 object-cover rounded border border-gray-300 dark:border-gray-600">
                    @else
                        <span class="text-gray-500 text-sm">No Image</span>
                    @endif
                </div>

            </div>

            <!-- Actions -->
            <div class="mt-6 flex justify-center space-x-2">

                <a href="{{ route('admin.courses.edit', $course) }}"
                    class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-md">
                    {{ __('Edit') }}
                </a>

                <form action="{{ route('admin.courses.destroy', $course) }}" method="POST"
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
