@props(['label', 'name', 'value' => null, 'checked' => false])

<label
    class="flex items-center space-x-3 p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer transition-colors text-sm text-gray-700 dark:text-gray-300">

    <input type="radio" name="{{ $name }}" value="{{ $value }}" @checked($checked)
        {{ $attributes->merge([
            'class' =>
                'permission-radio w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer transition-colors',
        ]) }}>

    <span>{{ $label }}</span>

</label>

@error($name)
    <span class="text-red-500 text-xs">{{ $message }}</span>
@enderror
