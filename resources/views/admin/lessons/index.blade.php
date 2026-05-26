<x-layouts.app>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ __('Lessons') }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                {{ __('Manage registered lessons') }}
            </p>
        </div>

        <x-button tag="a" href="{{ route('admin.lessons.create') }}" icon="fas-plus">
            {{ __('Add Lesson') }}
        </x-button>
    </div>

    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

            <!-- Table Head -->
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Course</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">Title
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Video</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Duration</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Order</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Preview</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Created</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                        Actions</th>
                </tr>
            </thead>
            <!-- Table Body -->
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($lessons as $lesson)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">

                        <!-- Index -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $lesson->id }}
                        </td>

                        <!-- Instructor -->
                        <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-100">
                            {{ $lesson->course->title ?? 'N/A' }}
                        </td>

                        <!-- Title -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $lesson->title }}
                        </td>

                        <!-- Video -->
                        <td>
                            @if ($lesson->hasMedia('video'))
                                <x-button tag="a" href="{{ $lesson->getFirstMediaUrl('video') }}" target="_blank"
                                    icon="fas-circle-play">Play</x-button>
                            @endif
                        </td>

                        <!-- Duration -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $lesson->formattedDuration }}
                        </td>

                        <!-- order -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $lesson->order }}
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 text-sm">
                            <span
                                class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                {{ $lesson->preview }}
                            </span>
                        </td>


                        <!-- Created -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $lesson->created_at->format('d M Y') }}
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-sm flex justify-end gap-2">
                            <x-button tag="a" href="{{ route('admin.lessons.show', $lesson) }}" type="info"
                                icon="fas-eye">View </x-button>

                            <x-button tag="a" href="{{ route('admin.lessons.edit', $lesson) }}" type="warning"
                                icon="fas-pencil">Edit</x-button>

                            <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST"
                                onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                @csrf
                                @method('DELETE')
                                <x-button type="danger" buttonType="submit" icon="fas-trash">Delete</x-button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500">
                            {{ __('No lessons found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $lessons->links() }}
    </div>

</x-layouts.app>
