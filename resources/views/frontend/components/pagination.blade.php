<div class="flex items-center justify-center gap-2 mt-10 flex-wrap">

    {{-- Previous Button --}}
    @if ($model->onFirstPage())
        <span
            class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-200 text-sm text-gray-400 cursor-not-allowed">
            &laquo;
        </span>
    @else
        <a href="{{ $model->previousPageUrl() }}"
            class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-200 text-sm hover:border-purple-400 hover:text-purple-600 transition">
            &laquo;
        </a>
    @endif

    {{-- Page Numbers (Only Nearby Pages) --}}
    @for ($i = max(1, $model->currentPage() - 2); $i <= min($model->lastPage(), $model->currentPage() + 2); $i++)
        @if ($i == $model->currentPage())
            <span
                class="w-9 h-9 flex items-center justify-center rounded-full bg-purple-600 text-white text-sm font-semibold">
                {{ $i }}
            </span>
        @else
            <a href="{{ $model->url($i) }}"
                class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-200 text-sm hover:border-purple-400 hover:text-purple-600 transition">
                {{ $i }}
            </a>
        @endif
    @endfor

    {{-- Next Button --}}
    @if ($model->hasMorePages())
        <a href="{{ $model->nextPageUrl() }}"
            class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-200 text-sm hover:border-purple-400 hover:text-purple-600 transition">
            &raquo;
        </a>
    @else
        <span
            class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-200 text-sm text-gray-400 cursor-not-allowed">
            &raquo;
        </span>
    @endif

</div>
