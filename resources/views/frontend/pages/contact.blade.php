@extends('frontend.layouts.app')

@section('title', 'Contact Us - SkillNest')

@section('content')

    {{-- Contact Info Cards --}}
    <section class="py-12 sm:py-16 bg-gray-50" data-reveal>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <div
                    class="bg-white rounded p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all group text-center">
                    <div
                        class="w-14 h-14 bg-purple-100 rounded flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-600 transition">
                        <i class="fas fa-envelope text-2xl text-purple-600 group-hover:text-white transition"></i>
                    </div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-1">Email Us</p>
                    <p class="font-bold text-gray-900 text-sm mb-1">admin@gmail.com</p>
                    <p class="text-xs text-gray-500">Typically replies within 2 hours</p>
                </div>

                <div
                    class="bg-white rounded p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all group text-center">
                    <div
                        class="w-14 h-14 bg-purple-100 rounded flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-600 transition">
                        <i class="fas fa-phone text-2xl text-purple-600 group-hover:text-white transition"></i>
                    </div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-1">Call Us</p>
                    <p class="font-bold text-gray-900 text-sm mb-1">+1 (800) 555-0199</p>
                    <p class="text-xs text-gray-500">Mon &ndash; Fri, 9 AM &ndash; 6 PM EST</p>
                </div>

                <div
                    class="bg-white rounded p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all group text-center">
                    <div
                        class="w-14 h-14 bg-purple-100 rounded flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-600 transition">
                        <i class="fas fa-comment-dots text-2xl text-purple-600 group-hover:text-white transition"></i>
                    </div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-1">Live Chat</p>
                    <p class="font-bold text-gray-900 text-sm mb-1">Start a live chat</p>
                    <p class="text-xs text-gray-500">Available 24/7 for learners</p>
                </div>

                <div
                    class="bg-white rounded p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all group text-center">
                    <div
                        class="w-14 h-14 bg-purple-100 rounded flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-600 transition">
                        <i class="fas fa-location-dot text-2xl text-purple-600 group-hover:text-white transition"></i>
                    </div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-1">Office</p>
                    <p class="font-bold text-gray-900 text-sm mb-1">222 Learning Ave, NY 10001</p>
                    <p class="text-xs text-gray-500">United States</p>
                </div>

            </div>
        </div>
    </section>

    {{-- Contact Form + FAQ --}}
    <section class="py-16 sm:py-20 lg:py-24 bg-white" data-reveal>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-start">

                {{-- Contact Form --}}
                <div>
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Send us a message</h2>
                    <p class="text-gray-600 mb-8">Fill out the form below and our team will get back to you shortly.</p>

                    <form action="{{ route('contact-us.store') }}" method="POST" x-data="contactForm()"
                        @submit.prevent="submit" class="bg-gray-50 rounded p-6 sm:p-8 border border-gray-100">
                        @csrf

                        {{-- Success State --}}
                        <div x-show="sent" x-cloak class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Message sent!</h3>
                            <p class="text-gray-500 mb-6">We'll get back to you within 2 hours on business days.</p>
                            <button type="button" @click="sent = false; resetForm()"
                                class="text-purple-600 font-semibold hover:underline">
                                Send another message
                            </button>
                        </div>

                        {{-- Form Fields --}}
                        <div x-show="!sent">

                            <div class="grid sm:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                        Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" x-model="form.name" placeholder="John"
                                        class="w-full border border-gray-200 rounded px-4 py-2.5 text-sm bg-white focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition"
                                        required>
                                    <p x-show="errors.name" x-text="errors.name" class="text-red-500 text-xs mt-1"></p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" x-model="form.email" placeholder="abc@gmail.com"
                                        class="w-full border border-gray-200 rounded px-4 py-2.5 text-sm bg-white focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition"
                                        required>
                                    <p x-show="errors.email" x-text="errors.email" class="text-red-500 text-xs mt-1"></p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Phone <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="phone" x-model="form.phone" placeholder="0000000"
                                    class="w-full border border-gray-200 rounded px-4 py-2.5 text-sm bg-white focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition"
                                    required>
                                <p x-show="errors.phone" x-text="errors.phone" class="text-red-500 text-xs mt-1"></p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Subject
                                </label>
                                <input type="text" name="subject" x-model="form.subject" placeholder="Type subject"
                                    class="w-full border border-gray-200 rounded px-4 py-2.5 text-sm bg-white focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition">
                                <p x-show="errors.subject" x-text="errors.subject" class="text-red-500 text-xs mt-1"></p>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Your message <span class="text-red-500">*</span>
                                </label>
                                <textarea name="message" x-model="form.message" rows="5"
                                    placeholder="Describe your issue or question in detail..."
                                    class="w-full border border-gray-200 rounded px-4 py-2.5 text-sm bg-white focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition resize-none"
                                    required></textarea>
                                <div class="flex justify-between mt-1">
                                    <p x-show="errors.message" x-text="errors.message" class="text-red-500 text-xs"></p>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded transition flex items-center justify-center gap-2"
                                :disabled="loading">
                                <span x-show="!loading">
                                    <i class="fas fa-paper-plane mr-1"></i>
                                    Send Message
                                </span>
                                <span x-show="loading" class="flex items-center gap-2">
                                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4" />
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                                    </svg>
                                    Sending...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- FAQ --}}
                <div>
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Frequently asked questions</h2>
                    <p class="text-gray-600 mb-8">
                        Can't find the answer you're looking for?
                    </p>

                    <div class="space-y-3">

                        <div class="bg-gray-50 rounded overflow-hidden border border-gray-100 hover:shadow-md transition"
                            x-data="{ open: false }">
                            <button type="button"
                                class="flex items-center justify-between w-full px-6 py-4 text-left gap-4"
                                @click="open = !open">
                                <span class="font-semibold text-gray-800 text-sm">How do I request a refund?</span>
                                <div class="w-8 h-8 bg-purple-100 rounded flex items-center justify-center flex-shrink-0 transition"
                                    :class="{ 'bg-purple-600': open }">
                                    <i class="fas fa-plus text-xs text-purple-600 transition"
                                        :class="{ 'rotate-45 text-white': open }"></i>
                                </div>
                            </button>
                            <div x-show="open" x-collapse class="px-6 pb-4 text-sm text-gray-600 leading-relaxed">
                                You can request a refund within 30 days of purchase if you are unsatisfied with the
                                course. Go to My Learning &rarr; the course &rarr; More &rarr; Leave / Refund. Refunds
                                are processed within 5&ndash;7 business days.
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded overflow-hidden border border-gray-100 hover:shadow-md transition"
                            x-data="{ open: false }">
                            <button type="button"
                                class="flex items-center justify-between w-full px-6 py-4 text-left gap-4"
                                @click="open = !open">
                                <span class="font-semibold text-gray-800 text-sm">My video won't play &mdash; what
                                    should I do?</span>
                                <div class="w-8 h-8 bg-purple-100 rounded flex items-center justify-center flex-shrink-0 transition"
                                    :class="{ 'bg-purple-600': open }">
                                    <i class="fas fa-plus text-xs text-purple-600 transition"
                                        :class="{ 'rotate-45 text-white': open }"></i>
                                </div>
                            </button>
                            <div x-show="open" x-collapse class="px-6 pb-4 text-sm text-gray-600 leading-relaxed">
                                Try clearing your browser cache, switching to a different browser, or disabling browser
                                extensions. If the issue persists, contact us with your browser version and operating
                                system.
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded overflow-hidden border border-gray-100 hover:shadow-md transition"
                            x-data="{ open: false }">
                            <button type="button"
                                class="flex items-center justify-between w-full px-6 py-4 text-left gap-4"
                                @click="open = !open">
                                <span class="font-semibold text-gray-800 text-sm">Can I download course materials for
                                    offline use?</span>
                                <div class="w-8 h-8 bg-purple-100 rounded flex items-center justify-center flex-shrink-0 transition"
                                    :class="{ 'bg-purple-600': open }">
                                    <i class="fas fa-plus text-xs text-purple-600 transition"
                                        :class="{ 'rotate-45 text-white': open }"></i>
                                </div>
                            </button>
                            <div x-show="open" x-collapse class="px-6 pb-4 text-sm text-gray-600 leading-relaxed">
                                Downloadable resources like PDFs and exercise files are available where instructors have
                                enabled them. Video download is available on our iOS and Android apps for Premium
                                subscribers.
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded overflow-hidden border border-gray-100 hover:shadow-md transition"
                            x-data="{ open: false }">
                            <button type="button"
                                class="flex items-center justify-between w-full px-6 py-4 text-left gap-4"
                                @click="open = !open">
                                <span class="font-semibold text-gray-800 text-sm">How do I become an instructor on
                                    SkillNest?</span>
                                <div class="w-8 h-8 bg-purple-100 rounded flex items-center justify-center flex-shrink-0 transition"
                                    :class="{ 'bg-purple-600': open }">
                                    <i class="fas fa-plus text-xs text-purple-600 transition"
                                        :class="{ 'rotate-45 text-white': open }"></i>
                                </div>
                            </button>
                            <div x-show="open" x-collapse class="px-6 pb-4 text-sm text-gray-600 leading-relaxed">
                                Click &ldquo;Teach on SkillNest&rdquo; in the header, fill in the application form, and
                                our team will review it within 3&ndash;5 business days.
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded overflow-hidden border border-gray-100 hover:shadow-md transition"
                            x-data="{ open: false }">
                            <button type="button"
                                class="flex items-center justify-between w-full px-6 py-4 text-left gap-4"
                                @click="open = !open">
                                <span class="font-semibold text-gray-800 text-sm">Are certificates included with all
                                    courses?</span>
                                <div class="w-8 h-8 bg-purple-100 rounded flex items-center justify-center flex-shrink-0 transition"
                                    :class="{ 'bg-purple-600': open }">
                                    <i class="fas fa-plus text-xs text-purple-600 transition"
                                        :class="{ 'rotate-45 text-white': open }"></i>
                                </div>
                            </button>
                            <div x-show="open" x-collapse class="px-6 pb-4 text-sm text-gray-600 leading-relaxed">
                                Yes! A certificate of completion is automatically generated when you finish 100% of a
                                course. You can download or share it directly from your profile.
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function contactForm() {
            return {
                loading: false,
                sent: false,
                form: {
                    name: '',
                    email: '',
                    phone: '',
                    subject: '',
                    message: '',
                },
                errors: {},

                async submit() {
                    this.errors = {};

                    if (!this.form.name.trim()) {
                        this.errors.name = 'Name is required.';
                        return;
                    }
                    if (!this.form.email.trim()) {
                        this.errors.email = 'Email is required.';
                        return;
                    }
                    if (!this.form.phone.trim()) {
                        this.errors.phone = 'Phone number is required.';
                        return;
                    }
                    if (!this.form.message.trim()) {
                        this.errors.message = 'Please write a message.';
                        return;
                    }
                    if (this.form.message.length > 1000) {
                        this.errors.message = 'Message must be under 1000 characters.';
                        return;
                    }

                    this.loading = true;

                    try {
                        const res = await fetch('{{ route('contact-us.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify(this.form),
                        });

                        const data = await res.json();

                        if (res.ok && data.success) {
                            this.sent = true;
                        } else if (data.errors) {
                            this.errors = data.errors;
                        } else {
                            alert(data.message || 'Something went wrong. Please try again.');
                        }
                    } catch (e) {
                        alert('Network error. Please try again.');
                    } finally {
                        this.loading = false;
                    }
                },

                resetForm() {
                    this.form = {
                        name: '',
                        email: '',
                        phone: '',
                        subject: '',
                        message: '',
                    };
                    this.errors = {};
                }
            }
        }
    </script>
@endpush
