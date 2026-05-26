<x-layouts.app>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ __('Contacts') }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                {{ __('Manage registered contact') }}
            </p>
        </div>

        <x-button tag="a" href="{{ route('admin.contacts.create') }}" icon="fas-plus">
            {{ __('Add Contact') }}
        </x-button>
    </div>

    {{-- Success Alert --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)"
            class="mb-4 flex items-center gap-3 px-4 py-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg text-sm">
            <i class="fas fa-circle-check text-green-500"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Reply Modal --}}
    <div x-data="{ open: false, contact: { id: null, name: '', email: '', message: '' } }" @open-reply-modal.window="contact = $event.detail; open = true">
        {{-- Backdrop --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm" @click="open = false"></div>

        {{-- Modal --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" class="fixed inset-0 z-50 flex items-center justify-center p-4"
            @click.self="open = false">
            <div
                class="w-full max-w-lg bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">

                {{-- Modal Header --}}
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 rounded-lg bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                            <i class="fas fa-reply text-indigo-600 dark:text-indigo-400 text-sm"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                {{ __('Reply to Contact') }}
                            </h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400" x-text="contact.email"></p>
                        </div>
                    </div>
                    <button @click="open = false"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                {{-- Original Message Preview --}}
                <div
                    class="mb-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">
                        {{ __('Original Message') }}
                    </p>
                    <p class="text-sm text-gray-700 dark:text-gray-300" x-text="contact.message"></p>
                </div>

                {{-- Reply Form --}}
                <form method="POST" :action="`{{ url('contacts') }}/${contact.id}/reply`">
                    @csrf

                    {{-- Hidden subject --}}
                    <input type="hidden" name="subject" :value="'Re: Message from ' + contact.name" />

                    {{-- To --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('To') }}
                        </label>
                        <input type="text" :value="contact.name + ' <' + contact.email + '>'" readonly
                            class="w-full px-3 py-2 text-sm rounded-lg bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed" />
                    </div>

                    {{-- Subject --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('Subject') }}
                        </label>
                        <input type="text" name="subject" :value="'Re: Message from ' + contact.name"
                            class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition" />
                    </div>

                    {{-- Reply Message --}}
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('Message') }} <span class="text-red-500">*</span>
                        </label>
                        <textarea name="reply" rows="5" required placeholder="{{ __('Write your reply here...') }}"
                            class="w-full px-3 py-2 text-sm rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition resize-none"></textarea>

                        @error('reply')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Modal Footer --}}
                    <div class="flex items-center justify-end gap-3">
                        <button type="button" @click="open = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors flex items-center gap-2">
                            <i class="fas fa-paper-plane text-xs"></i>
                            {{ __('Send Reply') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Contacts Table --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        #</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Name</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Email</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Message</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Status</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        IP Address</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Created</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                        Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($contacts as $contact)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">

                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $contact->id }}
                        </td>

                        <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-100">
                            {{ $contact->name }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $contact->email }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 max-w-xs truncate">
                            {{ $contact->message }}
                        </td>

                        {{-- Status Badge --}}
                        <td class="px-6 py-4 text-sm">
                            @php
                                $statusClasses = [
                                    'pending' =>
                                        'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                    'read' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                    'replied' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                ];
                                $statusIcons = [
                                    'pending' => 'fas fa-clock',
                                    'read' => 'fas fa-eye',
                                    'replied' => 'fas fa-check-circle',
                                ];
                                $cls = $statusClasses[$contact->status] ?? 'bg-gray-100 text-gray-600';
                                $icon = $statusIcons[$contact->status] ?? 'fas fa-circle';
                            @endphp
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $cls }}">
                                <i class="{{ $icon }} text-[10px]"></i>
                                {{ ucfirst($contact->status) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $contact->ip_address }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-nowrap">
                            {{ $contact->created_at->format('d M Y') }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center justify-end gap-2">

                                {{-- View --}}
                                <x-button tag="a" href="{{ route('admin.contacts.show', $contact) }}"
                                    type="info" icon="fas-eye">
                                    View
                                </x-button>

                                {{-- Reply Button — opens modal --}}
                                @if ($contact->status !== 'replied')
                                    <button type="button"
                                        @click="$dispatch('open-reply-modal', {
                                            id: {{ $contact->id }},
                                            name: @js($contact->name),
                                            email: @js($contact->email),
                                            message: @js($contact->message)
                                        })"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-indigo-900/30 dark:hover:text-indigo-400 rounded-lg transition-colors">
                                        <i class="fas fa-reply text-xs"></i>
                                        Reply
                                    </button>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 rounded-lg cursor-default">
                                        <i class="fas fa-check text-xs"></i>
                                        Replied
                                    </span>
                                @endif

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-2 text-gray-400 dark:text-gray-500">
                                <i class="fas fa-inbox text-3xl"></i>
                                <p class="text-sm">{{ __('No contacts found') }}</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $contacts->links() }}
    </div>

</x-layouts.app>
