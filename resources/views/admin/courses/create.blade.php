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

            <form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data">

                @csrf

                <!-- STEP 1: Course Info -->
                <div x-show="step === 1">

                    <h2 class="text-xl font-bold mb-4">Course Info</h2>

                    <x-forms.select label="Instructor" name="instructor_id" :options="$users" />

                    <x-forms.input label="Title" name="title" />

                    <x-forms.textarea label="Description" name="description" />

                    <x-forms.file-upload label="Thumbnail" name="thumbnail" />

                    <x-forms.input label="Price" name="price" type="number" step="0.01" />

                    <x-forms.input label="Original Price" name="original_price" type="number" step="0.01" />

                    <x-forms.select label="Level" name="level" :options="App\Models\Course::LEVEL_OPTIONS" />

                    <x-forms.input label="Course Duration (in days)" name="duration" type="number"
                        placeholder="e.g. 7" />

                </div>


                <!-- STEP 2: Categories -->
                <div x-show="step === 2">

                    <h2 class="text-xl font-bold mb-4">Categories</h2>

                    <x-forms.select label="Categories" name="categories[]" :options="$categories" multiple />

                </div>


                <!-- STEP 3: Sections -->
                <div x-show="step === 3">

                    <h2 class="text-xl font-bold mb-4">Sections</h2>

                    <template x-for="(section, index) in sections" :key="index">

                        <div class="flex gap-2 mb-2 items-end">

                            <x-forms.input label="" type="text" x-bind:name="'sections[' + index + '][title]'"
                                x-model="section.title" placeholder="Section title" />

                            <x-button type="button" @click="removeSection(index)" type="danger" icon="fas-x">
                            </x-button>

                        </div>

                    </template>

                    <x-button type="primary" @click="addSection">
                        Add Section
                    </x-button>

                </div>


                <!-- STEP 4: Review -->
                <div x-show="step === 4">

                    <h2 class="text-xl font-bold mb-4">Review & Submit</h2>

                    <p>Click submit to create the course.</p>

                </div>


                <!-- Navigation -->
                <div class="flex justify-between mt-6">

                    <x-button type="secondary" x-show="step > 1" @click="step--"> Previous
                    </x-button>

                    <x-button type="primary" x-show="step < 4" @click="step++"> next
                    </x-button>

                    <x-button buttonType="submit" type="success" x-show="step === 4"> Submit
                    </x-button>

                </div>

            </form>

        </div>

    </div>


    <script>
        function courseWizard() {
            return {
                step: 1,

                sections: [{
                    title: ''
                }],

                addSection() {
                    this.sections.push({
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
