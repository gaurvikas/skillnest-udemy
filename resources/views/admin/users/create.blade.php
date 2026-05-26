<x-layouts.app>
    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="mb-3">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Create a User') }}</h1>
            </div>

            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-3" enctype="multipart/form-data">
                @csrf
                <!-- Name Input -->
                <div>
                    <x-forms.input label="Name" name="name" type="text" placeholder="John Doe" />
                </div>

                <!-- Email Input -->
                <div>
                    <x-forms.input label="Email" name="email" type="email" placeholder="your@email.com" />
                </div>

                <!-- Password Input -->
                <div>
                    <x-forms.input label="Password" name="password" type="password" placeholder="••••••••" />
                </div>

                <div>
                    <x-forms.file-upload label="Image" name="image" />
                </div>

                <div>
                    <x-forms.select label="Assign Role" name="role[]" :options=$roles :selected="old('role')" multiple />
                </div>
                <!-- Login Button -->
                <x-button buttonType="submit" class="mt-4">{{ __('Create') }}</x-button>
            </form>
        </div>
    </div>
</x-layouts.app>
