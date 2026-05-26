<x-layouts.app>
    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">

            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                    {{ __('View Role') }}
                </h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    {{ __('View role details and assigned permissions') }}
                </p>
            </div>

            <!-- Role Name -->
            <div class="space-y-6">

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Role Name') }}
                    </label>

                    <div
                        class="w-full px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                        {{ $role->name }}
                    </div>
                </div>

                <!-- Permissions Section -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">

                    <div class="mb-4">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                            {{ __('Assigned Permissions') }}
                        </h2>
                    </div>

                    @php
                        $rolePermissions = $role->permissions->pluck('id')->toArray();

                        $groupedPermissions = $permissions->groupBy(function ($permission) {
                            $parts = explode(' ', $permission->name);
                            return count($parts) > 1 ? ucfirst($parts[1]) : 'Other';
                        });
                    @endphp

                    <div class="space-y-4">

                        @forelse($groupedPermissions as $groupName => $groupPermissions)

                            <div
                                class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4 border border-gray-200 dark:border-gray-600">

                                <!-- Group Title -->
                                <div class="mb-3">
                                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        {{ __($groupName) }}
                                    </h3>
                                </div>

                                <!-- Permissions Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">

                                    @foreach ($groupPermissions as $permission)
                                        <div
                                            class="flex items-center px-3 py-2 rounded-lg border 
                                            {{ in_array($permission->id, $rolePermissions)
                                                ? 'bg-green-50 border-green-300 dark:bg-green-900/20 dark:border-green-700'
                                                : 'bg-gray-100 border-gray-200 dark:bg-gray-700 dark:border-gray-600' }}">

                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">
                                                {{ ucfirst($permission->name) }}
                                            </span>

                                        </div>
                                    @endforeach

                                </div>
                            </div>

                        @empty
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                {{ __('No permissions found') }}
                            </div>
                        @endforelse

                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">

                    <x-button tag="a" href="{{ route('admin.roles.index') }}" type="secondary">
                        {{ __('Back') }}
                    </x-button>

                    <x-button tag="a" href="{{ route('admin.roles.edit', $role->id) }}" type="primary">
                        {{ __('Edit Role') }}
                    </x-button>

                </div>

            </div>
        </div>
    </div>
</x-layouts.app>
