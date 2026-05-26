<aside :class="{ 'w-full md:w-64': sidebarOpen, 'w-0 md:w-16 hidden md:block': !sidebarOpen }"
    class="bg-sidebar text-sidebar-foreground border-r border-gray-200 dark:border-gray-700 sidebar-transition overflow-hidden">
    <!-- Sidebar Content -->
    <div class="h-full flex flex-col">
        <!-- Sidebar Menu -->
        <nav class="flex-1 overflow-y-auto custom-scrollbar py-4">
            <ul class="space-y-1 px-2">

                <!-- Dashboard -->
                <x-layouts.sidebar-link href="{{ route('dashboard') }}" icon='fas-house'
                    :active="request()->routeIs('dashboard*')">Dashboard</x-layouts.sidebar-link>

                <!-- Users & Roles -->
                @canany(['user.view', 'role.view'])

                    <x-layouts.sidebar-two-level-link-parent title="Users & Roles" icon="fas-users" :active="request()->routeIs('admin.users*', 'admin.roles*')">

                        @can('user.view')
                            <x-layouts.sidebar-two-level-link href="{{ route('admin.users.index') }}" icon='fas-user'
                                :active="request()->routeIs('admin.users*')">All Users</x-layouts.sidebar-two-level-link>
                        @endcan

                        @can('role.view')
                            <x-layouts.sidebar-two-level-link href="{{ route('admin.roles.index') }}" icon='fas-user-shield'
                                :active="request()->routeIs('admin.roles*')">Roles & Permissions</x-layouts.sidebar-two-level-link>
                        @endcan

                    </x-layouts.sidebar-two-level-link-parent>

                @endcanany

                <!-- Learning Management -->
                @canany(['course.view', 'lesson.view', 'enrollment.view', 'lesson-progress.view', 'course-review.view',
                    'certificate.view'])

                    <x-layouts.sidebar-two-level-link-parent title="Learning Management" icon="fas-book-open"
                        :active="request()->routeIs(
                            'admin.courses*',
                            'admin.lessons*',
                            'admin.enrollments*',
                            'admin.lesson-progress*',
                            'admin.course-reviews*',
                            'admin.certificates*',
                            'admin.categories*',
                        )">

                        @can('category.view')
                            <x-layouts.sidebar-two-level-link href="{{ route('admin.categories.index') }}"
                                icon='fas-layer-group' :active="request()->routeIs('admin.categories*')">Categories</x-layouts.sidebar-two-level-link>
                        @endcan

                        @can('course.view')
                            <x-layouts.sidebar-two-level-link href="{{ route('admin.courses.index') }}" icon='fas-book'
                                :active="request()->routeIs('admin.courses*')">Courses</x-layouts.sidebar-two-level-link>
                        @endcan

                        @can('lesson.view')
                            <x-layouts.sidebar-two-level-link href="{{ route('admin.lessons.index') }}" icon='fas-file-video'
                                :active="request()->routeIs('admin.lessons*')">Lessons</x-layouts.sidebar-two-level-link>
                        @endcan

                        @can('enrollment.view')
                            <x-layouts.sidebar-two-level-link href="{{ route('admin.enrollments.index') }}"
                                icon='fas-file-circle-plus' :active="request()->routeIs('admin.enrollments*')">Enrollments</x-layouts.sidebar-two-level-link>
                        @endcan

                        @can('lesson-progress.view')
                            <x-layouts.sidebar-two-level-link href="{{ route('admin.lesson-progress.index') }}"
                                icon='fas-bars-progress' :active="request()->routeIs('admin.lesson-progress*')">Lesson Progress</x-layouts.sidebar-two-level-link>
                        @endcan

                        @can('course-review.view')
                            <x-layouts.sidebar-two-level-link href="{{ route('admin.course-reviews.index') }}"
                                icon='fas-rectangle-list' :active="request()->routeIs('admin.course-reviews*')">Reviews</x-layouts.sidebar-two-level-link>
                        @endcan

                        @can('certificate.view')
                            <x-layouts.sidebar-two-level-link href="{{ route('admin.certificates.index') }}"
                                icon='fas-certificate' :active="request()->routeIs('admin.certificates*')">Certificates</x-layouts.sidebar-two-level-link>
                        @endcan

                    </x-layouts.sidebar-two-level-link-parent>

                @endcanany

                <!-- Commerce & Support -->
                <x-layouts.sidebar-two-level-link-parent title="Commerce & Support" icon="fas-headset"
                    :active="request()->routeIs('admin.coupons*', 'admin.contacts*')">

                    {{-- @can('coupon.view') --}}
                    <x-layouts.sidebar-two-level-link href="{{ route('admin.coupons.index') }}" icon='fas-layer-group'
                        :active="request()->routeIs('admin.coupons*')">Coupons</x-layouts.sidebar-two-level-link>
                    {{-- @endcan --}}

                    {{-- @can('contact.view') --}}
                    <x-layouts.sidebar-two-level-link href="{{ route('admin.contacts.index') }}"
                        icon='fas-file-contract' :active="request()->routeIs('admin.contacts*')">Contact Inbox</x-layouts.sidebar-two-level-link>
                    {{-- @endcan --}}

                </x-layouts.sidebar-two-level-link-parent>

            </ul>
        </nav>
    </div>
</aside>
