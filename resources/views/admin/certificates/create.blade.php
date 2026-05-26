<x-layouts.app>
    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="mb-3">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Create a Certificate Review') }}
                </h1>
            </div>

            <form method="POST" action="{{ route('admin.certificates.store') }}" class="space-y-3"
                enctype="multipart/form-data">
                @csrf
                <!-- Name Input -->
                <div>
                    <x-forms.select label="User" name="user_id" :options="$users" placeholder="Choose User" />
                </div>

                <div>
                    <x-forms.select label="Course" name="course_id" :options="$course" placeholder="Choose Course" />
                </div>

                <div>
                    <x-forms.file-upload label="File Path" name="file_path" />
                </div>

                <div>
                    <x-forms.input label="Issued At" name="issued_at" type="date" placeholder="issue" />
                </div>

                <!-- Login Button -->
                <x-button buttonType="submit" class="mt-4">{{ __('Create') }}</x-button>
            </form>
        </div>
    </div>
</x-layouts.app>
