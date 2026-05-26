<x-layouts.app>

    {{-- Import Modal (Alpine.js) --}}
    <div x-data="{ open: false }" x-init="open = false" x-cloak>
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                    {{ __('Courses') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    {{ __('Manage registered courses') }}
                </p>
            </div>

            <div class="flex items-center gap-2">
                <x-button tag="a" href="{{ route('courses.export') }}" icon="fas-file-export">
                    {{ __('Export') }}
                </x-button>

                {{-- Import button now triggers modal --}}
                <x-button @click="open = true" icon="fas-file-import">
                    {{ __('Import') }}
                </x-button>

                <x-button tag="a" href="{{ route('admin.courses.create') }}" icon="fas-plus">
                    {{ __('Add Course') }}
                </x-button>
            </div>
        </div>

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
                class="w-full max-w-md bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">

                {{-- Modal Header --}}
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                            <i class="fas fa-file-import text-blue-600 dark:text-blue-400 text-sm"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                            {{ __('Import Courses') }}
                        </h2>
                    </div>
                    <button @click="open = false"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                {{-- Modal Body --}}
                <form action="{{ route('courses.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Select File') }}
                        </label>

                        <label x-data="{ fileName: '' }"
                            class="group flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-blue-400 dark:hover:border-blue-500 hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-all duration-200">
                            <div x-show="!fileName"
                                class="flex flex-col items-center gap-2 text-gray-400 dark:text-gray-500">
                                <i
                                    class="fas fa-cloud-upload-alt text-3xl group-hover:text-blue-400 transition-colors"></i>
                                <span class="text-sm">{{ __('Click to upload or drag & drop') }}</span>
                                <span class="text-xs">{{ __('CSV, XLSX up to 10MB') }}</span>
                            </div>
                            <div x-show="fileName"
                                class="flex flex-col items-center gap-2 text-blue-600 dark:text-blue-400">
                                <i class="fas fa-file-check text-3xl"></i>
                                <span class="text-sm font-medium" x-text="fileName"></span>
                            </div>
                            <input type="file" name="file" accept=".csv,.xlsx,.xls" class="hidden" required
                                @change="fileName = $event.target.files[0]?.name ?? ''">
                        </label>

                        @error('file')
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
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors flex items-center gap-2">
                            <i class="fas fa-file-import text-xs"></i>
                            {{ __('Import') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>

        {{-- Table & rest of page --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                <!-- Table Head -->
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                            #</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                            Instructor</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                            Title
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                            Thumbnail</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                            Price
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                            Level
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                            Status</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                            Duration</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                            Created</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Actions</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($courses as $course)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">

                            <!-- Index -->
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ $course->id }}
                            </td>

                            <!-- Instructor -->
                            <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-100">
                                {{ $course->instructor->name ?? 'N/A' }}
                            </td>

                            <!-- Title -->
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ $course->title }}
                            </td>

                            <!-- Thumbnail -->
                            <td class="px-6 py-4 text-sm">
                                @if ($course->hasMedia('thumbnail'))
                                    <img src="{{ $course->getFirstMediaUrl('thumbnail') }}" alt="Thumbnail"
                                        class="w-12 h-12 rounded object-cover">
                                @else
                                    <span class="text-gray-400">No Image</span>
                                @endif
                            </td>

                            <!-- Price -->
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                ${{ number_format($course->price, 2) }}
                            </td>

                            <!-- Level -->
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ ucfirst($course->level) }}
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 text-sm">
                                <span
                                    class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                    {{ ucfirst($course->status) }}
                                </span>
                            </td>


                            <!-- Duration -->
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ $course->duration }} min
                            </td>

                            <!-- Created -->
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ $course->created_at->format('d M Y') }}
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 text-sm flex justify-end gap-2">
                                <x-button tag="a" href="{{ route('admin.courses.show', $course) }}"
                                    type="info" icon="fas-eye">View </x-button>

                                <x-button tag="a" href="{{ route('admin.courses.edit', $course) }}"
                                    type="warning" icon="fas-pencil">Edit</x-button>

                                <form action="{{ route('admin.courses.destroy', $course) }}" method="POST"
                                    onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="danger" buttonType="submit" icon="fas-trash">Delete</x-button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ __('No courses found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $courses->links() }}
        </div>

    </div>

</x-layouts.app>
