<x-layouts.app>
    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="mb-3">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Edit Lesson Progress') }}</h1>
            </div>

            <form method="POST" action="{{ route('admin.lesson-progress.update', $LessonProgress->id) }}"
                class="space-y-3">
                @csrf
                @method('PUT')
                <!-- Name Input -->

                <div>
                    <x-forms.select label="User" name="user_id" :options="$users" placeholder="Choose User"
                        :selected="$LessonProgress->user_id" />
                </div>
                <div>
                    <x-forms.select label="lesson" name="lesson_id" :options="$lessons" placeholder="Choose lesson"
                        :selected="$LessonProgress->lesson_id" />
                </div>

                <div>
                    <x-forms.input label="Watched Seconds" name="watched_seconds" type="number" placeholder="e.g. 120"
                        min="0" max="100" step="1" value="{{ $LessonProgress->watched_seconds }}" />
                </div>

                <div>
                    <label class="block ml-1 text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Is
                        Completed</label>

                    <div class="flex gap-2">
                        @foreach (App\Models\Lessonprogress::IS_COMPLETE as $key => $label)
                            <x-forms.radio :label="$label" name="is_completed" :value="$key" :checked="old('is_completed', $LessonProgress->is_completed) == $key" />
                        @endforeach
                    </div>
                </div>

                <div>
                    <x-forms.input label="Completed At" name="completed_at" type="date"
                        value="{{ \Carbon\Carbon::parse($LessonProgress->completed_at)->format('Y-m-d') }}" />
                </div>

                <!-- Login Button -->
                <x-button buttonType="submit" class="mt-4">{{ __('Update') }}</x-button>
            </form>
        </div>
    </div>
</x-layouts.app>
