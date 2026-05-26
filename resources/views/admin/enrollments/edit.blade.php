<x-layouts.app>
    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="mb-3">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Update an Enrollment') }}</h1>
            </div>

            <form method="POST" action="{{ route('admin.enrollments.update', $enrollment->id) }}" class="space-y-3">
                @csrf
                @method('PUT')
                <!-- Name Input -->
                <div>
                    <x-forms.select label="User" name="user_id" :options="$users" placeholder="Choose User"
                        :selected="$enrollment->user_id" />
                </div>

                <div>
                    <x-forms.select label="Course" name="course_id" :options="$courses" placeholder="Choose Course"
                        :selected="$enrollment->course_id" />
                </div>

                <x-forms.input label="Enrolled At" name="enrolled_at" type="date"
                    value="{{ \Carbon\Carbon::parse($enrollment->enrolled_at)->format('Y-m-d') }}" />


                <div>
                    <x-forms.input label="Progress Percentage" name="progress_percentage" type="number" min="0"
                        max="100" step="1" value="{{ $enrollment->progress_percentage }}" />
                </div>

                <div>
                    <x-forms.input label="Completed At" name="completed_at" type="date"
                        value="{{ \Carbon\Carbon::parse($enrollment->completed_at)->format('Y-m-d') }}" />
                </div>

                <!-- Login Button -->
                <x-button buttonType="submit" class="mt-4">{{ __('Update') }}</x-button>
            </form>
        </div>
    </div>
</x-layouts.app>
