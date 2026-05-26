<x-layouts.app>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ __('Users') }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                {{ __('Manage registered users') }}
            </p>
        </div>

        <x-button tag="a" href="{{ route('admin.users.create') }}" icon="fas-plus"> {{ __('Add User') }}
        </x-button>
    </div>

    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        #
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Name
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Email
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Role
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Image
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Created
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $user->id }}
                        </td>

                        <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-100">
                            {{ $user->name }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $user->email }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ implode(',', $user->roles()->pluck('name')->toArray()) }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            @if ($user->hasMedia('image'))
                                <img src="{{ $user->getFirstMediaUrl('image') }}" alt="Thumbnail"
                                    class="w-12 h-12 rounded object-cover">
                            @else
                                <span class="text-gray-400">No Image</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $user->created_at->format('d M Y') }}
                        </td>

                        <td class="flex justify-end gap-2 px-6 py-4 text-sm">

                            <!-- View -->
                            <x-button tag="a" href="{{ route('admin.users.show', $user) }}" type="info"
                                icon="fas-eye">
                                View
                            </x-button>

                            <!-- Edit -->
                            <x-button tag="a" href="{{ route('admin.users.edit', $user) }}" type="warning"
                                icon="fas-pencil">
                                Edit
                            </x-button>

                            <!-- Delete -->
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                class="inline-block" onsubmit="return confirm('{{ __('Are you sure?') }}')">
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
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            {{ __('No users found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>

</x-layouts.app>
