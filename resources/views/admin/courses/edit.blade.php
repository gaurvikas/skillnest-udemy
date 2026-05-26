<x-layouts.app>

    <div x-data="courseWizard()" class="mx-auto">

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">

            <!-- Progress -->
            <div class="flex mb-6 gap-2">
                <template x-for="i in 4">
                    <div class="flex-1">
                        <div class="h-2 rounded" :class="step >= i ? 'bg-blue-600' : 'bg-gray-300'">
                        </div>
                    </div>
                </template>
            </div>


            <form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <!-- STEP 1: Course Info -->
                <div x-show="step === 1">

                    <h2 class="text-xl font-bold mb-4">Course Info</h2>

                    <x-forms.select label="Instructor" name="instructor_id" :options="$users" :selected="$course->instructor_id" />
                    <x-forms.input label="Title" name="title" :value="$course->title" />

                    <div>
                        <x-forms.textarea label="Description" name="description" type="text"
                            value="{{ $course->description }}" placeholder="description" />
                    </div>

                    <x-forms.file-upload label="Thumbnail" name="thumbnail" :image="$course->getFirstMediaUrl('thumbnail')" />

                    @if ($course->thumbnail)
                        <img src="{{ Storage::url($course->thumbnail) }}" class="w-40 mt-2 rounded">
                    @endif

                    <x-forms.input label="Price" name="price" type="number" step="0.01" :value="$course->price" />

                    <x-forms.input label="Original Price" name="original_price" type="number" step="0.01"
                        :value="$course->original_price" />

                    <x-forms.select label="Level" name="level" :options="App\Models\Course::LEVEL_OPTIONS" :selected="$course->level" />

                    <x-forms.input label="Duration" name="duration" type="number" :value="$course->duration" />

                    <x-forms.select label="Status" name="status" :options="App\Models\Course::STATUS_OPTIONS" :selected="$course->status" />
                </div>

                <!-- STEP 2: Categories -->
                <div x-show="step === 2">
                    <h2 class="text-xl font-bold mb-4">Categories</h2>
                    <x-forms.select label="Categories" name="categories[]" :options="$categories" :selected="$course->categories->pluck('id')->toArray()"
                        multiple />
                </div>

                <!-- STEP 3: Sections -->
                <div x-show="step === 3">

                    <h2 class="text-xl font-bold mb-4">Sections</h2>

                    <template x-for="(section, index) in sections" :key="index">

                        <div class="flex gap-2 mb-2 items-end">

                            <input type="hidden" :name="'sections[' + index + '][id]'" x-model="section.id">

                            <x-forms.input label="" type="text" x-bind:name="'sections[' + index + '][title]'"
                                x-model="section.title" placeholder="Section title" />

                            <x-button type="button" @click="removeSection(index)" type="danger">
                                Remove
                            </x-button>

                        </div>

                    </template>

                    <x-button type="button" @click="addSection">
                        Add Section
                    </x-button>

                </div>

                <!-- STEP 4 -->
                <div x-show="step === 4">

                    <h2 class="text-xl font-bold mb-4">Review</h2>

                    <p>Update the course.</p>

                </div>

                <!-- Navigation -->
                <div class="flex justify-between mt-6">

                    <x-button type="secondary" x-show="step > 1" @click="step--">
                        Previous
                    </x-button>

                    <x-button type="primary" x-show="step < 4" @click="step++">
                        Next
                    </x-button>

                    <x-button buttonType="submit" type="success" x-show="step === 4">
                        Update
                    </x-button>

                </div>
            </form>
        </div>

    </div>

    <!-- Alpine Script -->
    <script>
        function courseWizard() {

            return {

                step: 1,

                sections: @json(
                    $course->sections->map(fn($s) => [
                            'id' => $s->id,
                            'title' => $s->title,
                        ])),

                addSection() {

                    this.sections.push({
                        id: null,
                        title: ''
                    })

                },

                removeSection(index) {

                    this.sections.splice(index, 1)

                }

            }

        }
    </script>

</x-layouts.app>
