<x-layouts.app>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ __('Enrollments') }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                {{ __('Manage registered enrollments') }}
            </p>
        </div>

        <x-button tag="a" href="{{ route('admin.enrollments.create') }}" icon="fas-plus">
            {{ __('Add Enrollment') }}
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
                        Course</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Enrolled At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Progress Percentage</th>
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
                @forelse ($enrollments as $enrollment)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">

                        <!-- Index -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $enrollment->id }}
                        </td>

                        <!-- User -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $enrollment->user->name ?? 'N/A' }}
                        </td>

                        <!-- Course -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $enrollment->course->title ?? 'N/A' }}
                        </td>

                        <!-- Enrolled At -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $enrollment->enrolled_at ?? 'N/A' }}
                        </td>

                        <!-- Progress Percentage -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $enrollment->progress_percentage ?? '0' }} %
                        </td>

                        <!-- Completed At -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $enrollment->completed_at ?? 'Not Completed' }}
                        </td>

                        <!-- Created -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $enrollment->created_at->format('d M Y') }}
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-sm flex justify-end gap-2">
                            <x-button tag="a" href="{{ route('admin.enrollments.show', $enrollment) }}"
                                type="info" icon="fas-eye">
                                View
                            </x-button>

                            <x-button tag="a" href="{{ route('admin.enrollments.edit', $enrollment) }}"
                                type="warning" icon="fas-pencil">
                                Edit
                            </x-button>

                            <form action="{{ route('admin.enrollments.destroy', $enrollment) }}" method="POST"
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
                            {{ __('No enrollments found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $enrollments->links() }}
    </div>

</x-layouts.app>
