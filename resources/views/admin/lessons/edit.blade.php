<x-layouts.app>

    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">

            <h1 class="text-2xl font-bold mb-6">
                Update Lesson
            </h1>

            <form method="POST" action="{{ route('admin.lessons.update', $lesson->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-4">

                    <input type="hidden" name="section_id" value="{{ $lesson->section_id }}">

                    <div>
                        <x-forms.input label="Title" type="text" name="title" value="{{ $lesson->title }}" />
                    </div>

                    <div>
                        <x-forms.textarea label="Content" name="content" value="{{ $lesson->content }}" />
                    </div>

                    <div>
                        <x-forms.input label="Order" type="number" name="order" value="{{ $lesson->order }}" />
                    </div>

                    <div>
                        <x-forms.video-upload label="Video" name="video" :video="$lesson->getFirstMediaUrl('video')" />
                    </div>

                    <div>
                        <label class="block mb-2">Is Preview</label>

                        <label>
                            <input type="radio" name="is_preview" value="1"
                                {{ $lesson->is_preview ? 'checked' : '' }}>
                            Yes
                        </label>

                        <label class="ml-4">
                            <input type="radio" name="is_preview" value="0"
                                {{ !$lesson->is_preview ? 'checked' : '' }}>
                            No
                        </label>

                    </div>

                    <x-button buttonType="submit">
                        Update Lesson
                    </x-button>

                </div>

            </form>

        </div>
    </div>

</x-layouts.app>
