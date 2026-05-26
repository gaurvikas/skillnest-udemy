<x-layouts.app>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ __('User Details') }}
            </h1>
        </div>

        <a href="{{ route('admin.users.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 text-sm font-medium rounded-md">
            &larr; {{ __('Back to Users') }}
        </a>
    </div>

    <!-- Center wrapper -->
    <div class="flex justify-center">
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 w-full max-w-md">
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">{{ __('Name') }}</span>
                    <span class="text-gray-800 dark:text-gray-100">{{ $user->name }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">{{ __('Email') }}</span>
                    <span class="text-gray-800 dark:text-gray-100">{{ $user->email }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">{{ __('Role') }}</span>
                    <span class="text-gray-800 dark:text-gray-100">{{ $user->role }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">{{ __('Created At') }}</span>
                    <span class="text-gray-800 dark:text-gray-100">{{ $user->created_at->format('d M Y') }}</span>
                </div>
            </div>

            <div class="mt-6 flex justify-center space-x-2">
                <a href="{{ route('admin.users.edit', $user) }}"
                    class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-md">
                    {{ __('Edit') }}
                </a>

                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                    onsubmit="return confirm('{{ __('Are you sure?') }}')">
                    @csrf
                    @method('DELETE')
                    <button buttonType="submit"
                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-md">
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

</x-layouts.app>