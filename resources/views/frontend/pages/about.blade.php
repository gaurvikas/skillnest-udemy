@extends('frontend.layouts.app')
@section('title', 'About Us - SkillNest Clone')
@section('content')

    {{-- Hero Section --}}
    <section class="bg-gradient-to-br from-purple-600 via-purple-700 to-pink-600 text-white py-16 sm:py-20 lg:py-24"
        data-reveal>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6">We're committed to improving lives through
                    learning</h1>
                <p class="text-lg sm:text-xl text-purple-100 mb-8">
                    Whether you want to learn or to share what you know, you've come to the right place. As a global
                    destination for online learning, we connect people through knowledge.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href=""
                        class="bg-white text-purple-600 hover:bg-gray-100 font-bold py-3 px-8 rounded transition">
                        Explore Courses
                    </a>
                    <a href="{{ route('instructor.index') }}"
                        class="bg-purple-800 hover:bg-purple-900 text-white font-bold py-3 px-8 rounded transition border-2 border-purple-400">
                        Become an Instructor
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Section --}}
    <section class="py-12 sm:py-16 bg-gray-50" data-reveal>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                @foreach ([['number' => '75M+', 'text' => 'Learners worldwide'], ['number' => '220,000+', 'text' => 'Courses available'], ['number' => '75+', 'text' => 'Languages'], ['number' => '1B+', 'text' => 'Course enrollments']] as $stat)
                    <div class="text-center">
                        <div class="text-3xl sm:text-4xl lg:text-5xl font-bold text-purple-600 mb-2">{{ $stat['number'] }}
                        </div>
                        <div class="text-sm sm:text-base text-gray-700">{{ $stat['text'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Mission Section --}}
    <section class="py-16 sm:py-20 lg:py-24 bg-white" data-reveal>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-6">Our mission: Transform lives
                        through learning</h2>
                    <p class="text-lg text-gray-700 mb-6">
                        Whether you want to learn a new skill, train your teams, or share what you know with the world,
                        you're in the right place. As a leader in online learning, we're here to help you achieve your goals
                        and transform your life.
                    </p>
                    <p class="text-lg text-gray-700 mb-6">
                        With our global catalog spanning the latest skills and topics, people and organizations everywhere
                        are able to adapt to change and thrive.
                    </p>
                    <a href="{{ route('instructor.index') }}"
                        class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded transition">
                        Start Teaching Today
                    </a>
                </div>
                <div class="relative">
                    <div class="aspect-w-16 aspect-h-9 rounded overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&auto=format&fit=crop"
                            alt="Team collaboration" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-purple-600 rounded -z-10 hidden lg:block">
                    </div>
                    <div class="absolute -top-6 -left-6 w-24 h-24 bg-pink-500 rounded-full -z-10 hidden lg:block"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- Origin Story --}}
    <section class="py-16 sm:py-20 lg:py-24 bg-gray-50" data-reveal>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center mb-12">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-6">Our origin story</h2>
                <p class="text-lg text-gray-700">
                    From an early age, SkillNest founder knew learning was the key to unlocking opportunity.
                </p>
            </div>
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1">
                    <div class="aspect-w-16 aspect-h-9 rounded overflow-hidden shadow-xl">
                        <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800&auto=format&fit=crop"
                            alt="Founders" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <div class="prose prose-lg max-w-none">
                        <p class="text-gray-700 mb-6">
                            Growing up in a small village, our founder had few educational opportunities — until he got a
                            computer. Fueled by his dream to compete in mathematics, he used the internet to learn his way
                            to a silver medal in the International Math Olympiad.
                        </p>
                        <p class="text-gray-700 mb-6">
                            After learning online changed his life, he partnered with co-founders to achieve a common goal:
                            <span class="font-bold text-purple-600">to make quality education accessible to all</span>.
                        </p>
                        <p class="text-gray-700">
                            What started in 2010 as a way to democratize education has grown into a global skills
                            marketplace where millions of people learn the skills they need to thrive.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Values Section --}}
    <section class="py-16 sm:py-20 lg:py-24 bg-white" data-reveal>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">Our values</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    At SkillNest, we're all learners and instructors. We live out our values every day to create a culture that
                    is diverse, inclusive, and committed to helping employees thrive.
                </p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ([['icon' => 'lightbulb', 'title' => 'Be Curious', 'description' => 'We embrace learning and experimentation to drive innovation and growth.'], ['icon' => 'users', 'title' => 'Be Inclusive', 'description' => 'We celebrate diversity and create an environment where everyone belongs.'], ['icon' => 'rocket', 'title' => 'Take Ownership', 'description' => 'We act like owners and take responsibility for our actions and outcomes.'], ['icon' => 'heart', 'title' => 'Care Deeply', 'description' => 'We genuinely care about our learners, instructors, and each other.']] as $value)
                    <div class="bg-gray-50 rounded p-8 hover:shadow-xl transition group">
                        <div
                            class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-purple-600 transition">
                            <i
                                class="fas fa-{{ $value['icon'] }} text-3xl text-purple-600 group-hover:text-white transition"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $value['title'] }}</h3>
                        <p class="text-gray-600">{{ $value['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Impact Section --}}
    <section class="py-16 sm:py-20 lg:py-24 bg-gradient-to-br from-purple-50 to-pink-50" data-reveal>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">Real impact, real stories</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    See how learning on SkillNest has transformed lives around the world
                </p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ([['name' => 'Angela Yu', 'role' => 'Developer & Instructor', 'story' => 'When Angela switched careers from surgery to development, she had no idea the impact she\'d later have on millions of learners.', 'image' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&auto=format&fit=crop'], ['name' => 'Chris Johnson', 'role' => 'Data Scientist', 'story' => 'Learning data science on SkillNest helped Chris transition from marketing to his dream role in tech.', 'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&auto=format&fit=crop'], ['name' => 'Sarah Miller', 'role' => 'UX Designer', 'story' => 'Sarah went from zero design knowledge to leading UX projects at a Fortune 500 company.', 'image' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&auto=format&fit=crop']] as $story)
                    <div class="bg-white rounded overflow-hidden shadow-lg hover:shadow-2xl transition group">
                        <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                            <img src="{{ $story['image'] }}" alt="{{ $story['name'] }}"
                                class="w-full h-48 object-cover group-hover:scale-110 transition duration-500">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $story['name'] }}</h3>
                            <p class="text-sm text-purple-600 font-semibold mb-4">{{ $story['role'] }}</p>
                            <p class="text-gray-600">{{ $story['story'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Solutions Section --}}
    <section class="py-16 sm:py-20 lg:py-24 bg-white" data-reveal>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">Solutions for every need</h2>
            </div>
            <div class="grid lg:grid-cols-2 gap-8">
                {{-- For Individuals --}}
                <div class="bg-gradient-to-br from-purple-600 to-pink-600 rounded p-8 sm:p-10 text-white">
                    <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-user-graduate text-3xl"></i>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-bold mb-4">For individuals</h3>
                    <p class="text-purple-100 mb-6 text-lg">
                        Explore thousands of courses in programming, design, business, and more. Learn at your own pace with
                        lifetime access on mobile and desktop.
                    </p>
                    <a href="#"
                        class="inline-block bg-white text-purple-600 hover:bg-gray-100 font-bold py-3 px-6 rounded transition">
                        Browse Courses
                    </a>
                </div>

                {{-- For Business --}}
                <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded p-8 sm:p-10 text-white">
                    <div class="w-16 h-16 bg-white/10 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-building text-3xl"></i>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-bold mb-4">For businesses</h3>
                    <p class="text-gray-300 mb-6 text-lg">
                        Upskill your teams with fresh, relevant courses. Get access to our curated collection designed for
                        business and technical growth.
                    </p>
                    <a href="#"
                        class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded transition">
                        Get SkillNest Business
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-16 sm:py-20 lg:py-24 bg-gradient-to-r from-purple-600 to-pink-600 text-white" data-reveal>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-6">Join us in transforming lives through learning</h2>
            <p class="text-lg sm:text-xl text-purple-100 mb-8">
                Whether you're here to learn or teach, we're excited to have you as part of our global community.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}"
                    class="bg-white text-purple-600 hover:bg-gray-100 font-bold py-4 px-8 rounded transition text-lg">
                    Get Started 
                </a>
                <a href="{{ route('instructor.index') }}"
                    class="bg-purple-800 hover:bg-purple-900 text-white font-bold py-4 px-8 rounded transition border-2 border-purple-400 text-lg">
                    Teach on SkillNest
                </a>
            </div>
        </div>
    </section>

@endsection
