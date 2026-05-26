<x-layouts.app>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ __('Coupons') }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                {{ __('Manage registered coupon') }}
            </p>
        </div>

        <x-button tag="a" href="{{ route('admin.coupons.create') }}" icon="fas-plus"> {{ __('Add Coupon') }}
        </x-button>
    </div>

    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        #
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Code
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Type
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Value
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Usage Limit
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Used Count
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-nowrap">
                        Created
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($coupons as $coupon)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $coupon->id }}
                        </td>

                        <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-100">
                            {{ $coupon->code }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $coupon->type }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            @if ($coupon->type === 'percentage')
                                {{ number_format($coupon->value, 0) }}%
                            @else
                                ${{ number_format($coupon->value, 2) }}
                            @endif
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $coupon->usage_limit }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $coupon->used_count }}
                        </td>

                        <!-- Created -->
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $coupon->created_at->format('d M Y') }}
                        </td>

                        <td class="flex justify-end gap-2 px-6 py-4 text-sm">

                            <!-- View -->
                            <x-button tag="a" href="{{ route('admin.coupons.show', $coupon) }}" type="info"
                                icon="fas-eye">
                                View
                            </x-button>

                            <!-- Edit -->
                            <x-button tag="a" href="{{ route('admin.coupons.edit', $coupon) }}" type="warning"
                                icon="fas-pencil">
                                Edit
                            </x-button>

                            <!-- Delete -->
                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST"
                                class="inline-block" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                @csrf
                                @method('DELETE')

                                <x-button type="danger" buttonType="submit" icon="fas-trash">
                                    Delete
                                </x-button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                            {{ __('No Coupons found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $coupons->links() }}
    </div>

</x-layouts.app>
