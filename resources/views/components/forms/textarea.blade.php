@props([
    'label',
    'name',
    'placeholder' => '',
    'value' => '',
    'rows' => 3,
    'error' => false,
    'class' => '',
    'labelClass' => '',
    'required' => false,
])

@if ($label)
    <label for="{{ $name }}"
        {{ $attributes->merge(['class' => 'block ml-1 text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 ' . $labelClass]) }}>
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
@endif

<textarea 
    id="{{ $name }}" 
    name="{{ $name }}" 
    rows="{{ $rows }}"
    placeholder="{{ $placeholder }}"
    {{ $required ? 'required' : '' }}
    {{ $attributes->merge(['class' => 'w-full px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent placeholder-gray-400 dark:placeholder-gray-500 resize-none transition-colors ' . $class]) }}
>{{ $value }}</textarea>

@error($name)
    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
@enderror