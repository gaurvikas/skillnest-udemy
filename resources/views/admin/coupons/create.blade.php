<x-layouts.app>
    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="mb-3">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Create a Coupon') }}</h1>
            </div>

            <form method="POST" action="{{ route('admin.coupons.store') }}" class="space-y-3">
                @csrf
                <!-- Code Input -->
                <div>
                    <x-forms.input label="Code" name="code" type="text" placeholder="B8FA12" />
                </div>

                <!-- Type Input -->
                <div>
                    <x-forms.select label="Type" name="type" :options="App\Models\Coupon::COUPON_TYPE" />
                </div>

                <!-- Value Input -->
                <div>
                    <x-forms.input label="Value" name="value" type="number" step="0.01" placeholder="10" />
                </div>

                <!-- Discount Input -->
                <div>
                    <x-forms.input label="Max Discount" name="max_discount" type="number" placeholder="20% off" />
                </div>

                <!-- Usage limit Input -->
                <div>
                    <x-forms.input label="Usage limit" name="usage_limit" type="number" placeholder="20" />
                </div>

                <!-- Usage Count Input -->
                <div>
                    <x-forms.input label="Usage Count" name="used_count" type="number" placeholder="20" />
                </div>

                <!-- Expires AT -->
                <div>
                    <x-forms.input label="Expire At" name="expires_at" type="date" placeholder="20" />
                </div>

                <!-- IS Active -->
                <label for="is_active" class="block ml-1 text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 ">
                    Is Active
                </label>
                <div class="flex gap-2">
                    <x-forms.radio label="{{ App\Models\Coupon::COUPON_ACTIVE[1] }}" name="is_active" value="1"
                        checked="{{ old('is_active') }}" />

                    <x-forms.radio label="{{ App\Models\Coupon::COUPON_ACTIVE[0] }}" name="is_active" value="0"
                        checked="{{ old('is_active') }}" />
                </div>


                <!-- Login Button -->
                <x-button buttonType="submit" class="mt-4">{{ __('Create') }}</x-button>
            </form>
        </div>
    </div>
</x-layouts.app>
