<x-layouts.app>
    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="mb-3">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Create a Contact') }}</h1>
            </div>

            <form method="POST" action="{{ route('admin.contacts.store') }}" class="space-y-3">
                @csrf

                <!-- Code Input -->
                <div>
                    <x-forms.input label="Name" name="name" type="text" placeholder="john doe" />
                </div>

                <!-- email Input -->
                <div>
                    <x-forms.input label="Email" name="email" type="email" placeholder="abc@gmail.com" />
                </div>

                <!-- Phone Input -->
                <div>
                    <x-forms.input label="Phone" name="phone" type="number" placeholder="00-00-00-00" />
                </div>

                <!-- Phone Input -->
                <div>
                    <x-forms.input label="Subject" name="subject" type="text" placeholder="Subject" />
                </div>

                <!-- Select Input -->
                <x-forms.select label="Status" name="status" :options="App\Models\Contact::STATUS_OPTIONS" placeholder="Choose Status" />

                <!-- message -->
                <div>
                    <x-forms.textarea label="Message" name="message" type="text" placeholder="Create Message" />
                </div>

                <!-- Login Button -->
                <x-button buttonType="submit" class="mt-4">{{ __('Create') }}</x-button>
            </form>
        </div>
    </div>
</x-layouts.app>
