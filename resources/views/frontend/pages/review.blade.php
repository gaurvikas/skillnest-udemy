{{-- resources/views/frontend/pages/review.blade.php --}}
@extends('frontend.layouts.app')
@section('title', 'Write a Review - SkillNest')
@section('content')

    <div class="min-h-screen bg-gray-50">

        {{-- Header Section --}}
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 md:px-8 py-6 sm:py-8">
                <div class="flex items-start gap-4 sm:gap-6">
                    {{-- Course Thumbnail - Hidden on mobile --}}
                    <div class="hidden sm:block shrink-0">
                        <img src="{{ $course->getFirstMediaUrl('thumbnail') ?: '🤖' }}" alt="{{ $course->title }}"
                            class="w-24 sm:w-32 h-16 sm:h-20 object-cover rounded-lg border border-gray-200">
                    </div>

                    {{-- Course Info --}}
                    <div class="flex-1 min-w-0">
                        <h1 class="font-sora text-xl sm:text-2xl lg:text-3xl font-extrabold text-gray-900 mb-2 line-clamp-2">
                            {{ $course->title }}
                        </h1>
                        <p class="text-sm sm:text-base text-gray-600">
                            Share your experience to help other students
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Review Form --}}
        <div class="max-w-4xl mx-auto px-4 sm:px-6 md:px-8 py-6 sm:py-8 md:py-10">

            <form action="{{ route('reviews.store', $course->id) }}" method="POST" class="space-y-6 sm:space-y-8">
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                @csrf

                {{-- Rating Section --}}
                <div class="bg-white rounded-xl border border-gray-200 p-5 sm:p-6 md:p-8">
                    <h2 class="font-bold text-lg sm:text-xl text-gray-900 mb-4 sm:mb-6">How would you rate this course?</h2>

                    <div class="flex flex-col items-center py-6 sm:py-8">
                        {{-- Star Rating --}}
                        <div class="flex items-center gap-2 sm:gap-3 mb-4" id="star-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button" onclick="setRating({{ $i }})"
                                    class="star-btn text-3xl sm:text-4xl md:text-5xl text-gray-300 hover:text-amber-400 transition-all duration-200 focus:outline-none"
                                    data-rating="{{ $i }}">
                                    <i class="fas fa-star"></i>
                                </button>
                            @endfor
                        </div>

                        {{-- Rating Text --}}
                        <p class="text-base sm:text-lg font-semibold text-gray-700" id="rating-text">
                            Select your rating
                        </p>

                        {{-- Hidden Input --}}
                        <input type="hidden" name="rating" id="rating-input" value="" required>
                    </div>

                    @error('rating')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Review Text Section --}}
                <div class="bg-white rounded-xl border border-gray-200 p-5 sm:p-6 md:p-8">
                    <h2 class="font-bold text-lg sm:text-xl text-gray-900 mb-2">Share your thoughts</h2>
                    <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6">
                        Tell other students about your experience with this course
                    </p>

                    <textarea name="review" id="review-text" rows="6"
                        placeholder="What did you learn? What did you enjoy? What could be improved?"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg text-sm sm:text-base outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition resize-none"
                        required>{{ old('review') }}</textarea>

                    <div class="flex items-center justify-between mt-3">
                        <p class="text-xs sm:text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Minimum 50 characters required
                        </p>
                        <p class="text-xs sm:text-sm text-gray-500" id="char-count">0 / 50</p>
                    </div>

                    @error('review')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Section --}}
                <div class="bg-white rounded-xl border border-gray-200 p-5 sm:p-6 md:p-8">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6">
                        <div class="flex-1">
                            <h3 class="font-bold text-base sm:text-lg text-gray-900 mb-1">Ready to submit?</h3>
                            <p class="text-sm text-gray-600">Your review will be public and help other students</p>
                        </div>
                        <div class="flex gap-3 w-full sm:w-auto">
                            <a href="{{ route('my-learning.index') }}"
                                class="flex-1 sm:flex-none px-4 sm:px-6 py-2.5 sm:py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition text-center text-sm sm:text-base">
                                Cancel
                            </a>
                            <button type="submit"
                                class="flex-1 sm:flex-none px-6 sm:px-8 py-2.5 sm:py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-lg transition shadow-md hover:shadow-lg text-sm sm:text-base">
                                Submit Review
                            </button>
                        </div>
                    </div>
                </div>

            </form>

            {{-- Guidelines Card --}}
            {{-- <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 sm:p-6 mt-6 sm:mt-8">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                        <i class="fas fa-lightbulb text-blue-600 text-sm sm:text-base"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-base sm:text-lg text-gray-900 mb-2">Review Guidelines</h3>
                        <ul class="space-y-2 text-sm sm:text-base text-gray-700">
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-600 mt-1 shrink-0"></i>
                                <span>Be specific about what you liked or didn't like</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-600 mt-1 shrink-0"></i>
                                <span>Focus on the course content and learning experience</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-600 mt-1 shrink-0"></i>
                                <span>Keep your review constructive and helpful</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-times text-red-600 mt-1 shrink-0"></i>
                                <span>Avoid offensive language or personal attacks</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> --}}

        </div>
    </div>

    @push('scripts')
        <script>
            let selectedRating = 0;
            const ratingTexts = {
                1: 'Poor',
                2: 'Fair',
                3: 'Good',
                4: 'Very Good',
                5: 'Excellent'
            };

            // Star Rating Function
            function setRating(rating) {
                selectedRating = rating;
                document.getElementById('rating-input').value = rating;
                document.getElementById('rating-text').textContent = ratingTexts[rating];

                // Update star colors
                document.querySelectorAll('.star-btn').forEach((btn, index) => {
                    if (index < rating) {
                        btn.classList.remove('text-gray-300');
                        btn.classList.add('text-amber-400');
                    } else {
                        btn.classList.remove('text-amber-400');
                        btn.classList.add('text-gray-300');
                    }
                });
            }

            // Character Counter
            const textarea = document.getElementById('review-text');
            const charCount = document.getElementById('char-count');

            textarea.addEventListener('input', function() {
                const count = this.value.length;
                charCount.textContent = count + ' / 50';

                if (count >= 50) {
                    charCount.classList.remove('text-gray-500');
                    charCount.classList.add('text-green-600', 'font-semibold');
                } else {
                    charCount.classList.remove('text-green-600', 'font-semibold');
                    charCount.classList.add('text-gray-500');
                }
            });

        </script>
    @endpush

@endsection
