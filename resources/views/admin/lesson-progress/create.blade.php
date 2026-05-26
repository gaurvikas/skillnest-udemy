<x-layouts.app>
    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="mb-3">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Create a Lesson Progress') }}</h1>
            </div>

            <form method="POST" action="{{ route('admin.lesson-progress.store') }}" class="space-y-3">
                @csrf
                <!-- Name Input -->

                <div>
                    <x-forms.select label="User" name="user_id" :options="$users" placeholder="Choose User" />
                </div>
                <div>
                    <x-forms.select label="lesson" name="lesson_id" :options="$lessons" placeholder="Choose lesson" />
                </div>

                <div>
                    <x-forms.input label="Watched Seconds" name="watched_seconds" type="number" placeholder="e.g. 120"
                        min="0" max="100" step="1" />
                </div>

                <div>
                    <label class="block ml-1 text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Is
                        Completed</label>

                    <div class="flex gap-2">
                        <x-forms.radio label="{{ App\Models\LessonProgress::IS_COMPLETE[1] }}" name="is_completed"
                            value="1" checked="{{ old('is_completed') }}" />

                        <x-forms.radio label="{{ App\Models\LessonProgress::IS_COMPLETE[0] }}" name="is_completed"
                            value="0" checked="{{ old('is_completed') }}" />
                    </div>
                </div>
                <div>
                    <x-forms.input label="Completed At" name="completed_at" type="date" />
                </div>

                <!-- Login Button -->
                <x-button buttonType="submit" class="mt-4">{{ __('Create') }}</x-button>
            </form>
        </div>
    </div>
</x-layouts.app>
