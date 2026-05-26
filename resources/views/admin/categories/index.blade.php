<x-layouts.app>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ __('Category') }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                {{ __('Manage registered Category') }}
            </p>
        </div>

        <x-button tag="a" href="{{ route('admin.categories.create') }}" icon="fas-plus">
            {{ __('Add Category') }}
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
                        Name
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Description
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Icon
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Parent
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                        Actions
                    </th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($categories as $category)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <!-- Index -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $category->id }}
                        </td>

                        <!-- name -->
                        <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-100">
                            {{ $category->name ?? 'N/A' }}
                        </td>

                        <!-- Description -->
                        <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-100">
                            {{ $category->description }}
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $category->status ?? 'N/A' }}
                        </td>

                        <!-- Icon -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $category->icon }}
                        </td>

                        <!-- parent_id -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $category->parent->name ?? 'N/A' }}
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-sm flex justify-end gap-2">
                            <x-button tag="a" href="{{ route('admin.categories.show', $category) }}"
                                type="info" icon="fas-eye">View </x-button>

                            <x-button tag="a" href="{{ route('admin.categories.edit', $category) }}"
                                type="warning" icon="fas-pencil">Edit</x-button>

                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                onSubmit="return confirm('{{ __('Are you sure?') }}')">
                                @csrf
                                @method('DELETE')
                                <x-button type="danger" buttonType="submit" icon="fas-trash">Delete</x-button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500">
                            {{ __('No CourseReview found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $categories->links() }}
    </div>

</x-layouts.app>
