<x-layouts.app>

    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ __('Enrollment Details') }}
            </h1>
        </div>

        <a href="{{ route('admin.enrollments.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 text-sm font-medium rounded-md">
            &larr; {{ __('Back to Enrollments') }}
        </a>
    </div>

    <!-- Center Wrapper -->
    <div class="flex justify-center">
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6 w-full max-w-md">

            <div class="space-y-4">

                <!-- User -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">{{ __('User') }}</span>
                    <span class="text-gray-800 dark:text-gray-100">
                        {{ $enrollment->user->name ?? '-' }}
                    </span>
                </div>

                <!-- Course -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">{{ __('Course') }}</span>
                    <span class="text-gray-800 text-end dark:text-gray-100">
                        {{ $enrollment->course->title ?? '-' }}
                    </span>
                </div>

                <!-- Enrolled At -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">{{ __('Enrolled At') }}</span>
                    <span class="text-gray-800 dark:text-gray-100">
                        {{ $enrollment->enrolled_at ?? '-' }}
                    </span>
                </div>

                <!-- Progress Percentage -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">{{ __('Progress Percentage') }}</span>
                    <span class="text-gray-800 dark:text-gray-100">
                        {{ $enrollment->progress_percentage ?? 0 }}%
                    </span>
                </div>

                <!-- Completed At -->
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">{{ __('Completed At') }}</span>
                    <span class="text-gray-800 dark:text-gray-100">
                        {{ $enrollment->completed_at ?? '-' }}
                    </span>
                </div>

            </div>

            <!-- Actions -->
            <div class="mt-6 flex justify-center space-x-2">

                <a href="{{ route('admin.enrollments.edit', $enrollment->id) }}"
                    class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-md">
                    {{ __('Edit') }}
                </a>

                <form action="{{ route('admin.enrollments.destroy', $enrollment->id) }}" method="POST"
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
