{{-- resources/views/components/navbar.blade.php --}}
@php
    $isLoggedIn = auth()->check();

    // User data (only if logged in)
    if ($isLoggedIn) {
        $userName = auth()->user()->name;
        $userEmail = auth()->user()->email;
        $userInitials = auth()->user()->initials();

        // Get notifications
        $notifications = auth()->user()->notifications()->latest()->take(5)->get();
        $unreadCount = auth()->user()->unreadNotifications()->count();
    }
@endphp

<nav class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm ">

    {{-- Main Row --}}
    <div class="flex items-center h-14 sm:h-16 px-4 sm:px-6 gap-2 sm:gap-3">

        {{-- Logo --}}
        <a href="{{ route('index') }}" class="tracking-tight shrink-0">
            <img src="{{ asset('logo-light.png') }}" alt="SkillNest" class="h-12">
        </a>

        {{-- Categories — lg+ --}}
        <a href="{{ route('categories.index') }}"><button
                class="hidden lg:flex items-center gap-1.5 text-sm font-medium text-gray-800 hover:bg-gray-100 px-3 py-1.5 rounded-lg transition shrink-0 whitespace-nowrap">
                <i class="fa fa-th-large text-xs"></i> Categories
            </button></a>

        {{-- Search — md+ --}}
        <form action="{{ route('courses.search') }}" method="GET"
            class="hidden md:flex flex-1 items-center border-2 rounded-full overflow-hidden focus-within:border-purple-600 focus-within:ring-2 focus-within:ring-purple-100 transition {{ isset($errors) && $errors->has('query') ? 'border-red-500' : 'border-gray-900' }}">
            <input type="text" name="query" placeholder="Search for anything..." required
                value="{{ request()->query('query') }}"
                class="flex-1 min-w-0 border-none outline-none px-4 py-2 text-sm bg-transparent text-gray-800 placeholder-gray-400">
            <button type="submit"
                class="bg-gray-900 hover:bg-purple-600 text-white px-4 py-2.5 text-sm transition-colors shrink-0">
                <i class="fa fa-search"></i>
            </button>
        </form>

        {{-- Right Side --}}
        <div class="flex items-center gap-1.5 sm:gap-2 ml-auto shrink-0">

            {{-- Teach on SkillNest --}}
            <a href="{{ route('instructor.index') }}" target="_blank"
                class="hidden xl:block text-sm font-medium text-gray-700 hover:text-purple-600 transition px-2 whitespace-nowrap">
                Teach on SkillNest
            </a>

            {{-- My Learning (only when logged in) --}}
            @if ($isLoggedIn)
                <a href="{{ route('my-learning.index') }}" target="_blank"
                    class="hidden xl:block text-sm font-medium text-gray-700 hover:text-purple-600 transition px-2 whitespace-nowrap">
                    My Learning
                </a>
            @endif

            {{-- Cart --}}
            <a href="{{ route('cart.index') }}"
                class="relative text-gray-800 hover:text-purple-600 p-2 rounded-full hover:bg-gray-100 transition">
                <i class="fa fa-shopping-cart text-lg sm:text-xl"></i>
                @if (auth()->user()?->cart?->items()->count() > 0)
                    <span
                        class="absolute -top-0.5 -right-1 bg-purple-600 text-white text-[10px] font-bold rounded-full px-1.5 py-px leading-[1.6]">
                        {{ auth()->user()->cart->items()->count() }}
                    </span>
                @endif
            </a>

            @if ($isLoggedIn)
                {{-- Notifications Dropdown --}}
                <div class="relative hidden sm:block">
                    <button onclick="toggleNotifications()" id="notifications-btn"
                        class="relative text-gray-800 hover:text-purple-600 p-2 rounded-full hover:bg-gray-100 transition">
                        <i class="fa fa-bell text-lg sm:text-xl"></i>
                        @if ($unreadCount > 0)
                            <span
                                class="absolute top-0.5 right-0.5 bg-red-500 text-white text-[10px] font-bold rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                        @endif
                    </button>

                    {{-- Notifications Dropdown --}}
                    <div id="notifications-dropdown"
                        class="hidden absolute right-0 top-full mt-2 w-80 sm:w-96 bg-white border border-gray-200 rounded-xl shadow-2xl overflow-hidden z-50">

                        {{-- Header --}}
                        <div class="px-4 py-3 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                            <h3 class="font-bold text-gray-900">Notifications</h3>
                            @if ($unreadCount > 0)
                                <form action="{{ route('read-all-notifications') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="text-xs text-purple-600 hover:text-purple-700 font-semibold cursor-pointer">
                                        Mark all as read
                                    </button>
                                </form>
                            @endif
                        </div>

                        {{-- Notifications List --}}
                        <div class="max-h-96 overflow-y-auto">
                            @forelse ($notifications as $notification)
                                <a href="{{ $notification->data['url'] ?? '#' }}"
                                    onclick="markAsRead('{{ $notification->id }}')"
                                    class="block px-4 py-3 hover:bg-gray-50 transition border-b border-gray-100 {{ is_null($notification->read_at) ? 'bg-purple-50/50' : '' }}">

                                    <div class="flex gap-3">
                                        {{-- Icon based on type --}}
                                        <div class="shrink-0 mt-0.5">
                                            @if ($notification->type === 'App\Notifications\CourseEnrolled')
                                                <div
                                                    class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                                    <i class="fa fa-check-circle text-green-600"></i>
                                                </div>
                                            @elseif ($notification->type === 'course-purchase')
                                                <div
                                                    class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                                                    <i class="fa fa-shopping-cart text-purple-600"></i>
                                                </div>
                                            @else
                                                <div
                                                    class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                                    <i class="fa fa-bell text-gray-600"></i>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Content --}}
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 mb-0.5">
                                                {{ $notification->data['title'] ?? 'Notification' }}
                                            </p>
                                            <p class="text-xs text-gray-600 line-clamp-2">
                                                {{ $notification->data['message'] ?? '' }}
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>

                                        {{-- Unread dot --}}
                                        @if (is_null($notification->read_at))
                                            <div class="shrink-0">
                                                <span class="inline-block w-2 h-2 bg-purple-600 rounded-full"></span>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            @empty
                                <div class="px-4 py-12 text-center">
                                    <div
                                        class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                                        <i class="fa fa-bell-slash text-2xl text-gray-400"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-900 mb-1">No notifications yet</p>
                                    <p class="text-xs text-gray-500">We'll notify you when something important happens
                                    </p>
                                </div>
                            @endforelse
                        </div>

                        {{-- Footer --}}
                        @if ($notifications->count() > 0)
                            <div class="px-4 py-3 border-t border-gray-100 bg-gray-50">
                                <a href="#"
                                    class="block text-center text-sm font-semibold text-purple-600 hover:text-purple-700">
                                    View all notifications
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- User Profile Dropdown --}}
                <div class="relative hidden sm:block">
                    <button onclick="toggleUserMenu()" id="user-menu-btn"
                        class="flex items-center gap-2 p-1.5 hover:bg-gray-100 rounded-xl transition">
                        <div
                            class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-violet-700 flex items-center justify-center text-white font-bold text-xs">
                            {{ $userInitials }}
                        </div>
                        <i class="fa fa-chevron-down text-xs text-gray-400 transition-transform" id="user-chevron"></i>
                    </button>

                    <div id="user-dropdown"
                        class="hidden absolute right-0 top-full mt-2 w-64 bg-white border border-gray-200 rounded-xl shadow-2xl overflow-hidden z-50">

                        <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-violet-700 flex items-center justify-center text-white font-bold text-base shrink-0">
                                    {{ $userInitials }}
                                </div>
                                <div class="min-w-0">
                                    <div class="font-semibold text-sm text-gray-900 truncate">{{ $userName }}</div>
                                    <div class="text-xs text-gray-400 truncate">{{ $userEmail }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="py-2">
                            <a href="{{ route('my-learning.index') }}" target="_blank"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                                <i class="fa fa-graduation-cap w-5 text-center text-gray-400"></i> My Learning
                            </a>
                            <a href="{{ route('cart.index') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                                <i class="fa fa-shopping-cart w-5 text-center text-gray-400"></i> My Cart
                            </a>
                            <a href="{{ route('wishlist.index') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                                <i class="fa fa-heart w-5 text-center text-gray-400"></i> Wishlist
                            </a>
                            <a href="#"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                                <i class="fa fa-bell w-5 text-center text-gray-400"></i> Notifications
                                @if ($unreadCount > 0)
                                    <span
                                        class="ml-auto bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                                        {{ $unreadCount }}
                                    </span>
                                @endif
                            </a>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        <div class="py-2">
                            <a href="{{ url('/profile') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                                <i class="fa fa-user w-5 text-center text-gray-400"></i> My Profile
                            </a>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        <div class="py-2">
                            <form action="{{ url('/logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition text-left">
                                    <i class="fa fa-sign-out-alt w-5 text-center"></i> Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                {{-- ========== NOT LOGGED IN: Login/Signup Buttons ========== --}}

                <a href="{{ url('/login') }}"
                    class="hidden sm:inline-block border-2 border-gray-900 text-gray-900 text-xs sm:text-sm font-semibold px-3 sm:px-4 py-1.5 rounded hover:bg-gray-900 hover:text-white transition whitespace-nowrap">
                    Log In
                </a>
                <a href="{{ url('/register') }}"
                    class="hidden sm:inline-block border-2 border-purple-700 bg-purple-600 hover:bg-purple-700 text-white text-xs sm:text-sm font-semibold px-3 sm:px-4 py-1.5 rounded transition whitespace-nowrap">
                    Sign Up
                </a>
            @endif

            {{-- Hamburger --}}
            <button id="nav-hamburger" onclick="toggleMobileMenu()"
                class="sm:hidden p-2 rounded-lg hover:bg-gray-100 transition text-gray-800 ml-1">
                <i class="fa fa-bars text-lg" id="hamburger-icon"></i>
            </button>
        </div>
    </div>

    {{-- Mobile Search --}}
    <div class="md:hidden px-4 pb-2.5">
        <form action="{{ route('courses.search') }}" method="GET"
            class="flex items-center border-2 border-gray-900 rounded-full overflow-hidden focus-within:border-purple-600 transition">
            <input type="text" name="q" placeholder="Search for anything..."
                value="{{ request()->query('query') }}"
                class="flex-1 min-w-0 border-none outline-none px-4 py-2 text-sm bg-transparent placeholder-gray-400">
            <button class="bg-gray-900 text-white px-4 py-2.5 text-sm shrink-0"><i class="fa fa-search"></i></button>
        </form>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="hidden sm:hidden border-t border-gray-200 bg-white shadow-lg">
        <div class="px-4 py-3 space-y-1">

            @if ($isLoggedIn)
                <div class="flex items-center gap-3 px-3 py-3 bg-purple-50 rounded-lg mb-2">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-violet-700 flex items-center justify-center text-white font-bold text-sm shrink-0">
                        {{ $userInitials }}</div>
                    <div class="min-w-0">
                        <div class="font-semibold text-sm text-gray-900 truncate">{{ $userName }}</div>
                        <div class="text-xs text-gray-500 truncate">{{ $userEmail }}</div>
                    </div>
                </div>
            @endif

            <a href="{{ route('index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                <i class="fa fa-home w-5 text-center text-gray-400"></i> Home
            </a>
            <a href="{{ url('/courses') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                <i class="fa fa-book w-5 text-center text-gray-400"></i> Browse Courses
            </a>

            @if ($isLoggedIn)
                <a href="{{ route('my-learning.index') }}" target="_blank"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                    <i class="fa fa-graduation-cap w-5 text-center text-gray-400"></i> My Learning
                </a>
            @endif

            <a href="{{ route('instructor.index') }}" target="_blank"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                <i class="fa fa-chalkboard-teacher w-5 text-center text-gray-400"></i> Teach on SkillNest
            </a>
            <a href="{{ route('cart.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                <i class="fa fa-shopping-cart w-5 text-center text-gray-400"></i> Cart
                @if (auth()->user()?->cart?->items()->count() > 0)
                    <span class="ml-auto bg-purple-600 text-white text-xs px-2 py-0.5 rounded-full font-bold">
                        {{ auth()->user()->cart->items()->count() }}
                    </span>
                @endif
            </a>

            @if ($isLoggedIn)
                <a href="{{ route('wishlist.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                    <i class="fa fa-heart w-5 text-center text-gray-400"></i> Wishlist
                </a>
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                    <i class="fa fa-bell w-5 text-center text-gray-400"></i> Notifications
                    @if ($unreadCount > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-0.5 rounded-full font-bold">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ url('/profile') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                    <i class="fa fa-user w-5 text-center text-gray-400"></i> My Profile
                </a>
                <div class="border-t border-gray-100 pt-2 mt-2">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition text-left">
                            <i class="fa fa-sign-out-alt w-5 text-center"></i> Log Out
                        </button>
                    </form>
                </div>
            @else
                <div class="border-t border-gray-100 pt-2 mt-2 space-y-2">
                    <a href="{{ route('login') }}"
                        class="block text-center border-2 border-gray-900 text-gray-900 font-semibold px-4 py-2.5 rounded-lg text-sm hover:bg-gray-900 hover:text-white transition">
                        Log In
                    </a>
                    <a href="{{ route('register') }}"
                        class="block text-center bg-purple-600 hover:bg-purple-700 text-white font-semibold px-4 py-2.5 rounded-lg text-sm transition">
                        Sign Up Free
                    </a>
                </div>
            @endif
        </div>
    </div>
</nav>

@push('scripts')
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('hamburger-icon');
            const isHidden = menu.classList.toggle('hidden');
            icon.className = isHidden ? 'fa fa-bars text-lg' : 'fa fa-times text-lg';
        }

        function toggleUserMenu() {
            const dropdown = document.getElementById('user-dropdown');
            const chevron = document.getElementById('user-chevron');

            // Close notifications if open
            const notificationsDropdown = document.getElementById('notifications-dropdown');
            if (notificationsDropdown) {
                notificationsDropdown.classList.add('hidden');
            }

            const isHidden = dropdown.classList.toggle('hidden');
            chevron.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(180deg)';
        }

        function toggleNotifications() {
            const dropdown = document.getElementById('notifications-dropdown');

            // Close user menu if open
            const userDropdown = document.getElementById('user-dropdown');
            if (userDropdown) {
                userDropdown.classList.add('hidden');
                const chevron = document.getElementById('user-chevron');
                if (chevron) chevron.style.transform = 'rotate(0deg)';
            }

            dropdown.classList.toggle('hidden');
        }

        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const userDropdown = document.getElementById('user-dropdown');
            const userBtn = document.getElementById('user-menu-btn');
            const notificationsDropdown = document.getElementById('notifications-dropdown');
            const notificationsBtn = document.getElementById('notifications-btn');

            // Close user dropdown
            if (userDropdown && userBtn && !userDropdown.contains(event.target) && !userBtn.contains(event
                    .target)) {
                userDropdown.classList.add('hidden');
                const chevron = document.getElementById('user-chevron');
                if (chevron) chevron.style.transform = 'rotate(0deg)';
            }

            // Close notifications dropdown
            if (notificationsDropdown && notificationsBtn && !notificationsDropdown.contains(event.target) && !
                notificationsBtn.contains(event.target)) {
                notificationsDropdown.classList.add('hidden');
            }
        });
    </script>
@endpush
