<x-layouts.app>

    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ __('Course Review Details') }}
            </h1>
        </div>

        <a href="{{ route('admin.course-reviews.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 text-sm font-medium rounded-md">
            &larry; {{ __('Back to Course Reviews') }}
        </a>
    </div>

    <!-- Center Wrapper -->
    <div class="flex justify-center">
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6 w-full max-w-md">

            <div class="space-y-4">

                <!-- User -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">
                        {{ __('User') }}
                    </span>
                    <span class="text-gray-800 dark:text-gray-100">
                        {{ $CourseReview->user->name ?? '-' }}
                    </span>
                </div>

                <!-- Course -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">
                        {{ __('Course') }}
                    </span>
                    <span class="text-gray-800 text-end dark:text-gray-100">
                        {{ $CourseReview->course->title ?? '-' }}
                    </span>
                </div>

                <!-- Rating -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">
                        {{ __('Rating') }}
                    </span>
                    <span class="text-gray-800 dark:text-gray-100">
                        {{ $CourseReview->rating ?? '-' }}/5
                    </span>
                </div>

                <!-- Review -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">
                        {{ __('Review') }}
                    </span>
                    <span class="text-gray-800 dark:text-gray-100 text-end max-w-xs">
                        {{ $CourseReview->review ?? '-' }}
                    </span>
                </div>

                <!-- Created At -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">
                        {{ __('Created At') }}
                    </span>
                    <span class="text-gray-800 dark:text-gray-100">
                        {{ $CourseReview->created_at?->format('d M Y') ?? '-' }}
                    </span>
                </div>

                <!-- Updated At -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">
                        {{ __('Updated At') }}
                    </span>
                    <span class="text-gray-800 dark:text-gray-100">
                        {{ $CourseReview->updated_at?->format('d M Y') ?? '-' }}
                    </span>
                </div>

            </div>

            <!-- Actions -->
            <div class="mt-6 flex justify-center space-x-2">

                <!-- Edit -->
                <a href="{{ route('admin.course-reviews.edit', $CourseReview->id) }}"
                    class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-md">
                    {{ __('Edit') }}
                </a>

                <!-- Delete -->
                <form action="{{ route('admin.course-reviews.destroy', $CourseReview->id) }}" method="POST"
                    onSubmit="return confirm('{{ __('Are you sure?') }}')">
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
