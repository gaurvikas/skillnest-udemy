<x-layouts.app>

    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">

            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">
                Create Lessons
            </h1>

            <form method="POST" action="{{ route('admin.lessons.store') }}" enctype="multipart/form-data"
                class="space-y-6">

                @csrf
                <!-- Course Select -->
                <div>
                    <x-forms.select label="Course" name="course_id" :options="$courses" placeholder="Choose Course" />
                </div>

                <!-- Sections Accordion -->
                <div id="sectionsAccordion" class="space-y-4"></div>

                <div>
                    <x-button buttonType="submit">Save Lessons</x-button>
                </div>

            </form>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const courseSelect = document.querySelector('[name="course_id"]');
            const accordion = document.getElementById('sectionsAccordion');

            let lessonIndexes = {}; // track per-section lesson count

            /* ---------------------------
               LOAD SECTIONS ON COURSE CHANGE
            --------------------------- */
            courseSelect.addEventListener('change', function() {

                const courseId = this.value;
                accordion.innerHTML = '';
                lessonIndexes = {};

                if (!courseId) return;

                fetch(`/admin/courses/${courseId}/sections`)
                    .then(res => res.json())
                    .then(sections => {

                        if (sections.length === 0) {
                            accordion.innerHTML =
                                '<p class="text-sm text-red-500">No sections found.</p>';
                            return;
                        }

                        sections.forEach(section => {

                            lessonIndexes[section.id] = 0;

                            const sectionWrapper = document.createElement('div');
                            sectionWrapper.className = "border rounded-lg overflow-hidden";

                            sectionWrapper.innerHTML = `
                        <!-- Accordion Header -->

                        <button type="button" class="w-full text-left p-4 bg-gray-100 dark:bg-gray-700 font-semibold toggleAccordion">${section.title}</button>

                        <!-- Accordion Body -->

                        <div class="hidden p-4 space-y-4 bg-gray-50 dark:bg-gray-900" id="section-body-${section.id}">

                            <div class="lessons-container space-y-4"></div>

                            <x-button data-section="${section.id}" class="addLessonBtn" icon="fas-plus"> Add Lesson</x-button>
                        </div>
                    `;

                            accordion.appendChild(sectionWrapper);
                        });

                        initAccordion();
                        initAddLessonButtons();
                    });
            });

            /* ---------------------------
               ACCORDION TOGGLE
            --------------------------- */
            function initAccordion() {
                document.querySelectorAll('.toggleAccordion').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const body = this.nextElementSibling;
                        body.classList.toggle('hidden');
                    });
                });
            }

            /* ---------------------------
               ADD LESSON BUTTON HANDLER
            --------------------------- */
            function initAddLessonButtons() {
                document.querySelectorAll('.addLessonBtn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const sectionId = this.dataset.section;
                        addLesson(sectionId);
                    });
                });
            }

            /* ---------------------------
               ADD LESSON TO SECTION
            --------------------------- */
            function addLesson(sectionId) {

                const container = document.querySelector(`#section-body-${sectionId} .lessons-container`);
                const index = lessonIndexes[sectionId];

                const lessonBlock = document.createElement('div');
                lessonBlock.className = "border p-4 rounded-lg bg-white dark:bg-gray-800 space-y-3";

                lessonBlock.innerHTML = `
            <input type="hidden" name="lessons[${sectionId}][${index}][section_id]" value="${sectionId}">

            <div>
                <x-forms.input label="Title" type="text" name="lessons[${sectionId}][${index}][title]"/>
            </div>

            <div>
                <x-forms.textarea label="Content" name="lessons[${sectionId}][${index}][content]" rows="2"/>
            </div>
            
            <div>
                <x-forms.video-upload label="Video" name="lessons[${sectionId}][${index}][video]"/>
            </div>

            <div>
                <x-forms.input type="number" label="Order" name="lessons[${sectionId}][${index}][order]"/>
            </div>
   
            <label class="block ml-1 text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"l>Is Preview</label>
                    <div class="flex gap-2">
                        <x-forms.radio label="{{ App\Models\Lesson::PREVIEW_OPTIONS[1] }}"  name="lessons[${sectionId}][${index}][is_preview]"/>

                        <x-forms.radio label="{{ App\Models\Lesson::PREVIEW_OPTIONS[0] }}"  name="lessons[${sectionId}][${index}][is_preview]"/>
                    </div>
            <button type="button" class="text-red-600 text-sm removeLesson"> Remove Lesson </button>
        `;

                container.appendChild(lessonBlock);

                lessonBlock.querySelector('.removeLesson').addEventListener('click', function() {
                    lessonBlock.remove();
                });

                lessonIndexes[sectionId]++;
            }

        });
    </script>

</x-layouts.app>
