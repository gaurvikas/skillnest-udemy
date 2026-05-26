@extends('frontend.pages.instructor.layout')
@section('title', 'Create New Course - Instructor')
@section('content')

    <div x-data="courseWizard()" class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <h1 class="font-sora text-xl sm:text-2xl font-bold">Create New Course</h1>
                <a href="{{ route('instructor.index') }}" class="text-gray-600 hover:text-purple-600 transition">
                    <i class="fas fa-times text-xl"></i>
                </a>
            </div>

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

                {{-- Progress Bar --}}
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex gap-2">
                        <template x-for="i in 4" :key="i">
                            <div class="flex-1">
                                <div class="h-2 rounded-full transition-all duration-300"
                                    :class="step >= i ? 'bg-purple-600' : 'bg-gray-300'">
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="flex justify-between mt-3 text-xs sm:text-sm font-semibold">
                        <span :class="step >= 1 ? 'text-purple-600' : 'text-gray-400'">Course Info</span>
                        <span :class="step >= 2 ? 'text-purple-600' : 'text-gray-400'">Categories</span>
                        <span :class="step >= 3 ? 'text-purple-600' : 'text-gray-400'">Sections & Lessons</span>
                        <span :class="step >= 4 ? 'text-purple-600' : 'text-gray-400'">Review</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('instructor.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- STEP 1: Course Info --}}
                    <div x-show="step === 1" x-transition class="p-6 space-y-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">📚 Course Information</h2>

                        {{-- Title --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Course Title *</label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                placeholder="e.g., Complete Web Development Bootcamp 2024"
                                class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition"
                                required>
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="6" placeholder="What will students learn in your course?"
                                class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition resize-none">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Thumbnail --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Course Thumbnail</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                <div id="preview-container" class="hidden mb-4">
                                    <img id="thumbnail-preview" class="max-w-full h-auto rounded-lg mx-auto"
                                        style="max-height: 200px;">
                                </div>
                                <input type="file" name="thumbnail" id="thumbnail-input" accept="image/*" class="hidden"
                                    onchange="previewThumbnail(event)">
                                <label for="thumbnail-input" class="cursor-pointer">
                                    <i id="upload-icon" class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                    <p id="image-text" class="text-gray-700 font-semibold">Upload Thumbnail</p>
                                    <p id="image-size" class="text-sm text-gray-500">1280x720 recommended</p>
                                </label>
                            </div>
                        </div>

                        {{-- Level & Duration --}}
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Level *</label>
                                <select name="level"
                                    class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 outline-none focus:border-purple-500 cursor-pointer"
                                    required>
                                    <option value="">Select level</option>
                                    @foreach (App\Models\Course::LEVEL_OPTIONS as $value => $label)
                                        <option value="{{ $value }}" {{ old('level') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Duration (in days)</label>
                                <input type="number" name="duration" placeholder="e.g., 12" step="0.5" min="0"
                                    class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition">
                            </div>
                        </div>

                        {{-- Pricing --}}
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Original Price ($) *</label>
                                <input type="number" name="original_price" placeholder="999" min="0" step="0.01"
                                    class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition"
                                    required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Discounted Price ($)</label>
                                <input type="number" name="price" placeholder="499" min="0" step="0.01"
                                    class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition">
                            </div>
                        </div>
                        {{-- Level & Duration --}}
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Status *</label>
                                <select name="status"
                                    class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 outline-none focus:border-purple-500 cursor-pointer"
                                    required>
                                    <option value="">Select level</option>
                                    @foreach (App\Models\Course::STATUS_OPTIONS as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('status') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    {{-- STEP 2: Categories --}}
                    <div x-show="step === 2" x-transition class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">🏷️ Select Categories</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach ($categories as $id => $name)
                                <label
                                    class="flex items-center gap-2 p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-400 hover:bg-purple-50 transition">
                                    <input type="checkbox" name="categories[]" value="{{ $id }}"
                                        class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                                    <span class="text-sm font-medium text-gray-700">{{ $name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- STEP 3: Sections & Lessons --}}
                    <div x-show="step === 3" x-transition class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-900">📑 Sections & Lessons</h2>
                            <button type="button" @click="addSection()"
                                class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 sm:px-7 py-3 rounded text-sm transition text-center">
                                <i class="fas fa-plus mr-2"></i>Add Section
                            </button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(section, sIndex) in sections" :key="sIndex">
                                <div class="border-2 border-gray-200 rounded-xl overflow-hidden">

                                    {{-- Section Header --}}
                                    <div class="flex items-center gap-3 bg-gray-50 px-4 py-3 border-b border-gray-200">
                                        <button type="button" @click="section.open = !section.open"
                                            class="text-gray-400 hover:text-purple-600 transition">
                                            <i class="fas"
                                                :class="section.open ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
                                        </button>

                                        <input type="text" :name="'sections[' + sIndex + '][title]'"
                                            x-model="section.title" :placeholder="'Section ' + (sIndex + 1) + ' title'"
                                            class="flex-1 bg-transparent text-gray-800 font-semibold text-sm outline-none border-b-2 border-transparent focus:border-purple-400 py-1 transition">

                                        <span class="text-xs text-gray-400 whitespace-nowrap"
                                            x-text="section.lessons.length + ' lesson(s)'"></span>

                                        <button type="button" @click="removeSection(sIndex)"
                                            class="text-red-400 hover:text-red-600 transition ml-2">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>

                                    {{-- Section Body: Lessons --}}
                                    <div x-show="section.open" x-transition class="p-4 space-y-4 bg-white">

                                        {{-- Lessons List --}}
                                        <template x-for="(lesson, lIndex) in section.lessons" :key="lIndex">
                                            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 space-y-3">

                                                {{-- Hidden section index --}}
                                                <input type="hidden"
                                                    :name="'sections[' + sIndex + '][lessons][' + lIndex + '][order]'"
                                                    :value="lIndex + 1">

                                                <div class="flex items-center justify-between mb-1">
                                                    <span class="text-xs font-bold text-purple-600 uppercase tracking-wide"
                                                        x-text="'Lesson ' + (lIndex + 1)"></span>
                                                    <button type="button" @click="removeLesson(sIndex, lIndex)"
                                                        class="text-red-400 hover:text-red-600 text-xs transition">
                                                        <i class="fas fa-times mr-1"></i>Remove
                                                    </button>
                                                </div>

                                                {{-- Lesson Title --}}
                                                <div>
                                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Title
                                                        *</label>
                                                    <input type="text"
                                                        :name="'sections[' + sIndex + '][lessons][' + lIndex + '][title]'"
                                                        x-model="lesson.title" placeholder="e.g., Introduction to HTML"
                                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition">
                                                </div>

                                                {{-- Lesson Content --}}
                                                <div>
                                                    <label
                                                        class="block text-xs font-semibold text-gray-600 mb-1">Content</label>
                                                    <textarea :name="'sections[' + sIndex + '][lessons][' + lIndex + '][content]'" x-model="lesson.content"
                                                        rows="2" placeholder="Lesson description or notes..."
                                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition resize-none"></textarea>
                                                </div>

                                                {{-- Duration & Order --}}
                                                <div class="grid grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Is
                                                            Preview?</label>
                                                        <div class="flex gap-4 mt-2">
                                                            <label class="flex items-center gap-1 text-sm cursor-pointer">
                                                                <input type="radio"
                                                                    :name="'sections[' + sIndex + '][lessons][' + lIndex +
                                                                        '][is_preview]'"
                                                                    value="1" x-model="lesson.is_preview"
                                                                    class="text-purple-600">
                                                                Yes
                                                            </label>
                                                            <label class="flex items-center gap-1 text-sm cursor-pointer">
                                                                <input type="radio"
                                                                    :name="'sections[' + sIndex + '][lessons][' + lIndex +
                                                                        '][is_preview]'"
                                                                    value="0" x-model="lesson.is_preview"
                                                                    class="text-purple-600">
                                                                No
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Video Upload --}}
                                                <div>
                                                    <label
                                                        class="block text-xs font-semibold text-gray-600 mb-1">Video</label>
                                                    <div
                                                        class="border border-dashed border-gray-300 rounded-lg p-3 text-center bg-white">
                                                        <input type="file"
                                                            :name="'sections[' + sIndex + '][lessons][' + lIndex + '][video]'"
                                                            accept="video/*" class="hidden"
                                                            :id="'video-' + sIndex + '-' + lIndex"
                                                            @change="lesson.videoName = $event.target.files[0]?.name || ''">
                                                        <label :for="'video-' + sIndex + '-' + lIndex"
                                                            class="cursor-pointer flex items-center justify-center gap-2 text-sm text-gray-500 hover:text-purple-600 transition">
                                                            <i class="fas fa-video"></i>
                                                            <span
                                                                x-text="lesson.videoName || 'Click to upload video'"></span>
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>
                                        </template>

                                        {{-- Add Lesson Button --}}
                                        <button type="button" @click="addLesson(sIndex)"
                                            class="w-full border-2 border-dashed border-purple-300 hover:border-purple-500 hover:bg-purple-50 text-purple-600 font-semibold py-2 rounded-lg transition text-sm">
                                            <i class="fas fa-plus mr-2"></i>Add Lesson to this Section
                                        </button>

                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- Empty State --}}
                        <div x-show="sections.length === 0" class="text-center py-12 text-gray-500">
                            <i class="fas fa-folder-open text-4xl mb-3 text-gray-300"></i>
                            <p class="font-medium">No sections added yet.</p>
                            <p class="text-sm mt-1">Click "Add Section" to get started.</p>
                        </div>
                    </div>

                    {{-- STEP 4: Review --}}
                    <div x-show="step === 4" x-transition class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">✅ Review & Submit</h2>
                        <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                            <p class="text-gray-700">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                Course information completed
                            </p>
                            <p class="text-gray-700">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                Categories selected
                            </p>
                            <p class="text-gray-700">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span x-text="sections.length"></span> section(s) added
                                with <span x-text="totalLessons()"></span> lesson(s)
                            </p>

                            {{-- Sections Summary --}}
                            <template x-for="(section, sIndex) in sections" :key="sIndex">
                                <div class="ml-6 pl-4 border-l-2 border-purple-200">
                                    <p class="text-sm font-semibold text-gray-700"
                                        x-text="'📑 ' + (section.title || 'Untitled Section') + ' (' + section.lessons.length + ' lessons)'">
                                    </p>
                                    <template x-for="(lesson, lIndex) in section.lessons" :key="lIndex">
                                        <p class="text-xs text-gray-500 ml-3 mt-1"
                                            x-text="'▸ ' + (lesson.title || 'Untitled Lesson')"></p>
                                    </template>
                                </div>
                            </template>

                            <div class="pt-4 border-t border-gray-300">
                                <p class="text-sm text-gray-600">Click submit to create your course along with all sections
                                    and lessons.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Navigation Buttons --}}
                    <div class="flex justify-between gap-4 px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <button type="button" x-show="step > 1" @click="step--"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 sm:px-7 py-3 rounded text-sm transition text-center">
                            <i class="fas fa-arrow-left mr-2"></i>Previous
                        </button>
                        <div class="flex-1"></div>

                        <button type="button" x-show="step < 4" @click="step++"
                            class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 sm:px-7 py-3 rounded text-sm transition text-center">
                            Next<i class="fas fa-arrow-right ml-2"></i>
                        </button>

                        <button type="submit" x-show="step === 4"
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 sm:px-7 py-3 rounded text-sm transition text-center">
                            <i class="fas fa-check mr-2"></i>Submit Course
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function courseWizard() {
                return {
                    step: 1,
                    sections: [],

                    addSection() {
                        this.sections.push({
                            title: '',
                            open: true,
                            lessons: []
                        });
                    },

                    removeSection(sIndex) {
                        this.sections.splice(sIndex, 1);
                    },

                    addLesson(sIndex) {
                        this.sections[sIndex].lessons.push({
                            title: '',
                            content: '',
                            duration: '',
                            is_preview: '0',
                            videoName: ''
                        });
                    },

                    removeLesson(sIndex, lIndex) {
                        this.sections[sIndex].lessons.splice(lIndex, 1);
                    },

                    totalLessons() {
                        return this.sections.reduce((sum, s) => sum + s.lessons.length, 0);
                    }
                }
            }

            function previewThumbnail(event) {
                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        document.getElementById('thumbnail-preview').src = e.target.result;
                        document.getElementById('preview-container').classList.remove('hidden');
                        document.getElementById('upload-icon').style.display = 'none';
                        document.getElementById('image-size').style.display = 'none';
                        document.getElementById('image-text').style.display = 'none';
                    }

                    reader.readAsDataURL(file);
                }
            }
        </script>
    @endpush

@endsection
