@props(['label', 'name', 'image' => null, 'placeholder' => 'Click to upload image', 'labelClass' => ''])

@if ($label)
    <label class="block ml-1 text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 {{ $labelClass }}">
        {{ $label }}
    </label>
@endif

<div x-data="{
    preview: '{{ $image ? asset($image) : '' }}',
    pick() { this.$refs.file.click() }
}" class="w-full">
    {{-- Hidden file input --}}
    <input type="file" name="{{ $name }}" accept="image/*" x-ref="file" class="hidden"
        @change="preview = URL.createObjectURL($event.target.files[0])">

    {{-- Dropbox field --}}
    <div @click="pick"
        class="w-full px-4 py-1.5 rounded-lg
               text-gray-700 dark:text-gray-300
               bg-gray-50 dark:bg-gray-700
               border border-gray-300 dark:border-gray-600
               focus-within:ring-2 focus-within:ring-blue-500
               cursor-pointer flex items-center gap-3">
        {{-- Preview --}}
        <div
            class="w-10 h-10 rounded border border-gray-300 dark:border-gray-600
                   overflow-hidden bg-white dark:bg-gray-800 flex-shrink-0">
            <template x-if="preview">
                <img :src="preview" class="w-full h-full object-cover">
            </template>

            <template x-if="!preview">
                <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">
                    IMG
                </div>
            </template>
        </div>

        {{-- Text --}}
        <div class="flex-1 text-sm truncate">
            <template x-if="preview">
                <span class="text-gray-600 dark:text-gray-300">
                    Image selected
                </span>
            </template>

            <template x-if="!preview">
                <span class="text-gray-400">
                    {{ $placeholder }}
                </span>
            </template>
        </div>
    </div>
</div>

@error($name)
    <span class="text-red-500 text-sm">{{ $message }}</span>
@enderror
