<footer class="bg-gray-900 text-white/80 pt-12 sm:pt-16 pb-8 px-4 sm:px-8 md:px-12">
    <div class="max-w-7xl mx-auto">

        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 sm:gap-10 mb-10 sm:mb-12">

            {{-- Brand --}}
            <div class="col-span-2 md:col-span-3 lg:col-span-2">
                <div class="font-sora text-2xl font-extrabold text-white mb-3">
                    <img src="{{ asset('logo-dark.png') }}" alt="SkillNest" class="h-12">
                </div>
                <p class="text-sm leading-relaxed text-white/60 max-w-xs">
                    The world's leading online learning platform. Trusted by 57M+ students globally.
                </p>
                <div class="flex gap-3 mt-5 flex-wrap">

                    <a href="https://www.facebook.com" target="_blank"
                        class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-white/70 hover:bg-purple-600 hover:text-white transition text-sm">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://x.com" target="_blank"
                        class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-white/70 hover:bg-purple-600 hover:text-white transition text-sm">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://in.linkedin.com/" target="_blank"
                        class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-white/70 hover:bg-purple-600 hover:text-white transition text-sm">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://www.instagram.com/" target="_blank"
                        class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-white/70 hover:bg-purple-600 hover:text-white transition text-sm">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.youtube.com/" target="_blank"
                        class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-white/70 hover:bg-purple-600 hover:text-white transition text-sm">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            {{-- Company --}}
            <div>
                <h4 class="text-sm font-bold text-white mb-4">Company</h4>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('index') }}"
                            class="text-xs text-white/55 hover:text-purple-300 transition">Home</a>
                    </li>
                    <li><a href="{{ url('about') }}"
                            class="text-xs text-white/55 hover:text-purple-300 transition">About Us</a>
                    </li>
                    <li><a href="{{ route('contact-us') }}"
                            class="text-xs text-white/55 hover:text-purple-300 transition">Contact Us</a>
                    </li>
                    <li><a href="{{ route('profile.index') }}"
                            class="text-xs text-white/55 hover:text-purple-300 transition">Account</a>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-bold text-white mb-4">Teach</h4>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('categories.index') }}"
                            class="text-xs text-white/55 hover:text-purple-300 transition">Categories</a>
                    </li>
                    <li><a href="{{ route('courses.search') }}"
                            class="text-xs text-white/55 hover:text-purple-300 transition">Courses</a>
                    </li>
                    <li><a href="{{ route('instructor.login') }}"
                            class="text-xs text-white/55 hover:text-purple-300 transition">Instructor Hub</a>
                    </li>
                    <li><a href="{{ route('my-learning.index') }}"
                            class="text-xs text-white/55 hover:text-purple-300 transition">Learn on SkillNest</a>
                    </li>
                </ul>
            </div>
        </div>

        <div
            class="border-t border-white/10 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-white/40">
            <span>© {{ date('Y') }} SkillNest Clone. All rights reserved.</span>
            <div class="flex gap-4 flex-wrap justify-center">
                @foreach (['Privacy Policy', 'Terms of Service', 'Sitemap'] as $link)
                    <a href="#" class="hover:text-white/70 transition">{{ $link }}</a>
                @endforeach
            </div>
        </div>
    </div>
</footer>
