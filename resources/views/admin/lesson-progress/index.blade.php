<x-layouts.app>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ __('Lesson Progress') }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                {{ __('Manage registered Lesson Progress') }}
            </p>
        </div>

        <x-button tag="a" href="{{ route('admin.lesson-progress.create') }}" icon="fas-plus">
            {{ __('Add Lesson Progress') }}
        </x-button>
    </div>

    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

            <!-- Table Head -->
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">User
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Lesson</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Watched Seconds</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Is Completed</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Completed At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Created</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                        Actions</th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($LessonProgress as $lessonProgress)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">

                        <!-- Index -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $LessonProgres->id }}
                        </td>

                        <!-- User -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $lessonProgress->user->name ?? 'N/A' }}
                        </td>

                        <!-- Course -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $lessonProgress->lesson->title ?? 'N/A' }}
                        </td>

                        <!-- Enrolled At -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $lessonProgress->watched_seconds ?? 'N/A' }}
                        </td>

                        <!-- Progress Percentage -->
                        <td class="px-6 py-4 text-sm">
                            <span
                                class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                {{ $lessonProgress->is_completed ?? '0' }}
                            </span>
                        </td>

                        <!-- Completed At -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $lessonProgress->completed_at ?? 'Not completed' }}
                        </td>


                        <!-- Created -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $lessonProgress->created_at->format('d M Y') }}
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-sm flex justify-end gap-2">
                            <x-button tag="a" href="{{ route('admin.lesson-progress.show', $lessonProgress) }}"
                                type="info" icon="fas-eye">
                                View
                            </x-button>

                            <x-button tag="a" href="{{ route('admin.lesson-progress.edit', $lessonProgress) }}"
                                type="warning" icon="fas-pencil">
                                Edit
                            </x-button>

                            <form action="{{ route('admin.lesson-progress.destroy', $lessonProgress) }}" method="POST"
                                onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                @csrf
                                @method('DELETE')
                                <x-button type="danger" buttonType="submit" icon="fas-trash">
                                    Delete
                                </x-button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                            {{ __('No lessonProgresss found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $LessonProgress->links() }}
    </div>

</x-layouts.app>
