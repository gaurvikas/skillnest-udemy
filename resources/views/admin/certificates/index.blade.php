<x-layouts.app>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ __('Certificate') }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                {{ __('Manage registered Certificate') }}
            </p>
        </div>

        <x-button tag="a" href="{{ route('admin.certificates.create') }}" icon="fas-plus">
            {{ __('Add Certificate') }}
        </x-button>
    </div>

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
                        User</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Course</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Certificate Number
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        File Path
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Issued At
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Created</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                        Actions</th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($certificates as $certificate)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <!-- Index -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $certificate->id }}
                        </td>

                        <!-- User -->
                        <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-100">
                            {{ $certificate->user->name ?? 'N/A' }}
                        </td>

                        <!-- Course -->
                        <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-100">
                            {{ $certificate->course->title ?? 'N/A' }}
                        </td>

                        <!-- certificate_number -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $certificate->certificate_number ?? 'N/A' }}
                        </td>

                        <!-- file_path -->
                        <td class="px-6 py-4 text-sm">
                            @if ($certificate->hasMedia('file_path'))
                                <img src="{{ $certificate->getFirstMediaUrl('file_path') }}" alt="file_path"
                                    class="w-12 h-12 rounded object-cover">
                            @else
                                <span class="text-gray-400">No Image</span>
                            @endif
                        </td>

                        <!-- issued_at -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $certificate->issued_at }}
                        </td>

                        <!-- Created -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $certificate->created_at->format('d M Y') }}
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-sm flex justify-end gap-2">
                            <x-button tag="a" href="{{ route('admin.certificates.show', $certificate) }}"
                                type="info" icon="fas-eye">View </x-button>

                            <x-button tag="a" href="{{ route('admin.certificates.edit', $certificate) }}"
                                type="warning" icon="fas-pencil">Edit</x-button>

                            <form action="{{ route('admin.certificates.destroy', $certificate) }}" method="POST"
                                onSubmit="return confirm('{{ __('Are you sure?') }}')">
                                @csrf
                                @method('DELETE')
                                <x-button type="danger" buttonType="submit" icon="fas-trash">Delete</x-button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500">
                            {{ __('No certificate found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $certificates->links() }}
    </div>

</x-layouts.app>
