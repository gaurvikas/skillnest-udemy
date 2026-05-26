@extends('frontend.pages.instructor.layout')
@section('title', 'Edit Course - Instructor')
@section('content')

    <div x-data="courseWizard()" class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Edit Course</h1>
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
                                <div
                                    class="h-2 rounded-full transition-all duration-300":class="step >= i ? 'bg-purple-600' : 'bg-gray-300'">
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="flex justify-between mt-3 text-xs sm:text-sm font-semibold">
                        <span :class="step >= 1 ? 'text-purple-600' : 'text-gray-400'">Course Info</span>
                        <span :class="step >= 2 ? 'text-purple-600' : 'text-gray-400'">Categories</span>
                        <span :class="step >= 3 ? 'text-purple-600' : 'text-gray-400'">Sections</span>
                        <span :class="step >= 4 ? 'text-purple-600' : 'text-gray-400'">Review</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('instructor.update', $course) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="instructor_id" value="{{ auth()->id() }}">

                    {{-- STEP 1: Course Info --}}
                    <div x-show="step === 1" x-transition class="p-6 space-y-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">📚 Course Information</h2>

                        {{-- Title --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Course Title *</label>
                            <input type="text" name="title" value="{{ $course->title }}"
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
                                class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition resize-none">{{ $course->description }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Thumbnail --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Course Thumbnail</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                <div id="preview-container" class="mb-4">
                                    <img id="thumbnail-preview" class="max-w-full h-auto rounded-lg mx-auto"
                                        src="{{ $course->getFirstMediaUrl('thumbnail') }}" style="max-height: 200px;">
                                </div>
                                <input type="file" name="thumbnail" id="thumbnail-input" accept="image/*" class="hidden"
                                    onchange="previewThumbnail(event)">
                                <label for="thumbnail-input" class="cursor-pointer">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-700 font-semibold">Upload Thumbnail</p>
                                    <p class="text-sm text-gray-500">1280x720 recommended</p>
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
                                        <option value="{{ $value }}"
                                            {{ $course->level == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Duration (hours)</label>
                                <input type="number" name="duration" placeholder="e.g., 12" step="0.5" min="0"
                                    value="{{ $course->duration }}"
                                    class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition">
                            </div>
                        </div>

                        {{-- Pricing --}}
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Original Price ($) *</label>
                                <input type="number" name="original_price" placeholder="999" min="0" step="0.01"
                                    value="{{ $course->original_price }}"
                                    class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition"
                                    required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Discounted Price ($)</label>
                                <input type="number" name="price" placeholder="499" min="0" step="0.01"
                                    value="{{ $course->price }}"
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

                                    <option value="">Select Status</option>

                                    @foreach (App\Models\Course::STATUS_OPTIONS as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ $course->status == $value ? 'selected' : '' }}>
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
                                        {{ in_array($id, $course->categories->pluck('id')->toArray()) ? 'checked' : '' }}
                                        class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                                    <span class="text-sm font-medium text-gray-700">{{ $name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- STEP 3: Sections --}}
                    <div x-show="step === 3" x-transition class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-900">📑 Course Sections</h2>
                            <button type="button" @click="addSection()"
                                class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-4 py-2 rounded-lg transition">
                                <i class="fas fa-plus mr-2"></i>Add Section
                            </button>
                        </div>

                        <div class="space-y-3">
                            <template x-for="(section, index) in sections" :key="index">
                                <div class="flex gap-2 items-center">
                                    <input type="text" :name="'sections[' + index + '][title]'" x-model="section.title"
                                        :placeholder="'Section ' + (index + 1) + ' title'"
                                        class="flex-1 border-2 border-gray-300 rounded-lg px-4 py-3 outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition">
                                    <button type="button" @click="removeSection(index)"
                                        class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-3 rounded-lg transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <div x-show="sections.length === 0" class="text-center py-8 text-gray-500">
                            <i class="fas fa-folder-open text-4xl mb-3"></i>
                            <p>No sections added yet. Click "Add Section" to get started.</p>
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
                                <span x-text="sections.length"></span> sections added
                            </p>
                            <div class="pt-4 border-t border-gray-300">
                                <p class="text-sm text-gray-600">Click submit to create your course. You can add lessons
                                    and content later.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Navigation Buttons --}}
                    <div class="flex justify-between gap-4 px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <button type="button" x-show="step > 1" @click="step--"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-3 rounded-lg transition">
                            <i class="fas fa-arrow-left mr-2"></i>Previous
                        </button>

                        <div class="flex-1"></div>

                        <button type="button" x-show="step < 4" @click="step++"
                            class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                            Next<i class="fas fa-arrow-right ml-2"></i>
                        </button>

                        <button type="submit" x-show="step === 4"
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-8 py-3 rounded-lg transition">
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
                        if (this.sections.length > 0) {
                            this.sections.splice(index, 1);
                        }
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
                    }
                    reader.readAsDataURL(file);
                }
            }
        </script>
    @endpush

@endsection
