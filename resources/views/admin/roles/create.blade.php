<x-layouts.app>
    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Create a Role') }}</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    {{ __('Define a new role and assign permissions') }}</p>
            </div>

            <form method="POST" action="{{ route('admin.roles.store') }}" class="space-y-6" id="roleForm">
                @csrf

                <!-- Role Name Input -->
                <div>
                    <x-forms.input label="Role Name" name="name" type="text"
                        placeholder="e.g., Admin, Instructer, Student" required value="{{ old('name') }}" />
                </div>

                <!-- Permissions Section -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <div class="flex items-center justify-between mb-4 flex-wrap gap-3">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                {{ __('Assign Permissions') }}</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Select existing permissions or create new ones') }}</p>
                        </div>
                        <div class="flex gap-2 flex-wrap">
                            <x-button type="secondary" onclick="window.rolePermissions.selectAll()">
                                {{ __('Select All') }}
                            </x-button>
                            <x-button type="secondary" onclick="window.rolePermissions.deselectAll()">
                                {{ __('Deselect All') }}
                            </x-button>
                            <x-button type="success" onclick="window.rolePermissions.openCreateModal()" icon="fas-plus">
                                {{ __('Create Permission') }}
                            </x-button>
                        </div>
                    </div>

                    <!-- Permissions Grid -->
                    <div class="space-y-4" id="permissionsContainer">
                        @php
                            // $permissions variable is passed from the controller
                            // Group permissions by their prefix (e.g., 'view users' -> 'users')
                            $groupedPermissions = $permissions->groupBy(function ($permission) {
                                // Extract the module name from permission name
                                // e.g., 'view users' -> 'Users', 'create posts' -> 'Posts'
                                $parts = explode(' ', $permission->name);
                                return count($parts) > 1 ? ucfirst($parts[1]) : 'Other';
                            });
                        @endphp

                        @forelse($groupedPermissions as $groupName => $groupPermissions)
                            <div class="permission-group bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4 border border-gray-200 dark:border-gray-600 transition-colors"
                                data-group="{{ Str::slug($groupName) }}">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        {{ __($groupName) }}
                                    </h3>
                                    <x-button type="link"
                                        onclick="window.rolePermissions.toggleGroup('{{ Str::slug($groupName) }}')">
                                        {{ __('Toggle All') }}
                                    </x-button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                    @foreach ($groupPermissions as $permission)
                                        <x-forms.checkbox label="{{ ucfirst($permission->name) }}" name="permissions[]"
                                            value="{{ $permission->id }}"
                                            checked="{{ in_array($permission->id, old('permissions', [])) }}"
                                            class="permission-checkbox {{ Str::slug($groupName) }}-checkbox" />
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <p class="text-lg font-medium mb-2">{{ __('No permissions found') }}</p>
                                <p class="text-sm mb-4">{{ __('Create your first permission to get started') }}</p>
                                <button type="success" onclick="window.rolePermissions.openCreateModal()"
                                    icon="fas-plus">
                                    {{ __('Create Permission') }}
                                </button>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                    <x-button tag="a" href="{{ route('admin.roles.index') }}" type="secondary">
                        {{ __('Cancel') }}
                    </x-button>
                    <x-button type="primary" buttonType="submit">
                        {{ __('Create Role') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Create Permission Modal -->
    <div id="createPermissionModal"
        class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full transform transition-all">
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('Create New Permission') }}
                </h3>
                <x-button type="link" onclick="window.rolePermissions.closeCreateModal()" icon="fas-x">
                </x-button>
            </div>

            <form id="createPermissionForm" class="p-6 space-y-4">
                @csrf
                <div>
                    <x-forms.input label="Permission Name" type="text" id="permissionNameInput"
                        name="permission_name" placeholder="e.g., view users, create posts, delete comments" required />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        {{ __('Use lowercase with spaces (e.g., "edit users")') }}</p>
                </div>

                <div>
                    <label for="guardNameInput" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Guard Name
                    </label>
                    <input type="text" id="guardNameInput" name="guard_name" value="web"
                        class="w-full px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-colors" />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('Default is "web"') }}</p>
                </div>

                <div id="permissionError"
                    class="hidden p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                    <p class="text-sm text-red-600 dark:text-red-400"></p>
                </div>

                <div id="permissionSuccess"
                    class="hidden p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                    <p class="text-sm text-green-600 dark:text-green-400"></p>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <x-button type="secondary" onclick="window.rolePermissions.closeCreateModal()">
                        {{ __('Cancel') }}
                    </x-button>
                    <x-button buttonType="submit" id="createPermissionBtn">
                        {{ __('Create') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Namespace to avoid global scope pollution
            window.rolePermissions = {
                // Select all checkboxes
                selectAll() {
                    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
                        checkbox.checked = true;
                    });
                },

                // Deselect all checkboxes
                deselectAll() {
                    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
                        checkbox.checked = false;
                    });
                },

                // Toggle all checkboxes in a specific group
                toggleGroup(groupSlug) {
                    const checkboxes = document.querySelectorAll(`.${groupSlug}-checkbox`);
                    const allChecked = Array.from(checkboxes).every(cb => cb.checked);

                    checkboxes.forEach(checkbox => {
                        checkbox.checked = !allChecked;
                    });
                },

                // Open create permission modal
                openCreateModal() {
                    document.getElementById('createPermissionModal').classList.remove('hidden');
                    document.getElementById('permissionNameInput').focus();
                    this.hideMessages();
                },

                // Close create permission modal
                closeCreateModal() {
                    document.getElementById('createPermissionModal').classList.add('hidden');
                    document.getElementById('createPermissionForm').reset();
                    this.hideMessages();
                },

                // Hide error and success messages
                hideMessages() {
                    document.getElementById('permissionError').classList.add('hidden');
                    document.getElementById('permissionSuccess').classList.add('hidden');
                },

                // Show error message
                showError(message) {
                    const errorDiv = document.getElementById('permissionError');
                    errorDiv.querySelector('p').textContent = message;
                    errorDiv.classList.remove('hidden');
                    document.getElementById('permissionSuccess').classList.add('hidden');
                },

                // Show success message
                showSuccess(message) {
                    const successDiv = document.getElementById('permissionSuccess');
                    successDiv.querySelector('p').textContent = message;
                    successDiv.classList.remove('hidden');
                    document.getElementById('permissionError').classList.add('hidden');
                },

                // Reload permissions dynamically
                // 
            };

            // Handle create permission form submission
            document.getElementById('createPermissionForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const btn = document.getElementById('createPermissionBtn');
                const originalBtnText = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML =
                    '<svg class="animate-spin h-4 w-4 mr-2 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Creating...';

                window.rolePermissions.hideMessages();

                const formData = new FormData(this);

                try {
                    const response = await fetch('{{ route('admin.roles.store-permission') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json',
                        },
                        body: formData
                    });

                    const data = await response.json();

                    console.log(response);

                    if (response.ok) {
                        window.rolePermissions.showSuccess(data.message || 'Permission created successfully!');
                        document.getElementById('permission_name').value = null;
                        window.location.reload();
                    } else {
                        window.rolePermissions.showError(data.message || 'Failed to create permission.');
                    }
                } catch (error) {
                    window.rolePermissions.showError('An error occurred. Please try again.');
                    console.error('Error:', error);
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = originalBtnText;
                }
            });

            // Close modal on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    window.rolePermissions.closeCreateModal();
                }
            });

            // Close modal on outside click
            document.getElementById('createPermissionModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    window.rolePermissions.closeCreateModal();
                }
            });

            // Add visual feedback when hovering over permission groups
            document.addEventListener('DOMContentLoaded', function() {
                const permissionLabels = document.querySelectorAll('.permission-group label');
                permissionLabels.forEach(label => {
                    label.addEventListener('mouseenter', function() {
                        this.classList.add('bg-blue-50', 'dark:bg-blue-900/20');
                    });
                    label.addEventListener('mouseleave', function() {
                        this.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
                    });
                });
            });
        </script>
    @endpush
</x-layouts.app>
