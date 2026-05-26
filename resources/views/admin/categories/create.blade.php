<x-layouts.app>
    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="mb-3">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Create a Category Review') }}
                </h1>
            </div>

            <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-3">
                @csrf
                <!-- Name Input -->
                <div>
                    <x-forms.input label="Name" name="name" type="text" placeholder="John Doe" />
                </div>

                <div>
                    <x-forms.textarea label="Description" name="description" type="text" placeholder="description" />
                </div>

                <x-forms.select label="Status" name="status" :options="App\Models\Category::STATUS_OPTIONS" placeholder="Choose Status" />
                
                <div>
                    <x-forms.input label="Icon" name="icon" type="text" placeholder="💻" />
                </div>

                <div>
                    <x-forms.select label="Parent Category" name="parent_id" :options="$categories"
                        placeholder="Choose Category" />
                </div>


                <!-- Login Button -->
                <x-button buttonType="submit" class="mt-4">{{ __('Create') }}</x-button>
            </form>
        </div>
    </div>
</x-layouts.app>
