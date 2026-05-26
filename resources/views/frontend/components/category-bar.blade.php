<div class="bg-white border-b  overflow-x-auto no-scrollbar">
    <div class="flex px-8 min-w-max justify-center">
        @foreach ($categories as $category)
            <div class="category-item inline-flex">
                <a href="{{ route('courses.search', ['category' => $category->slug]) }}"
                    class="px-4 py-3.5 text-sm font-medium whitespace-nowrap transition-colors
                        {{ request()->query(key: 'category') === $category->slug
                            ? 'text-purple-600 border-purple-600'
                            : 'border-transparent hover:text-purple-600' }}">
                    {{ $category->name }}
                </a>
                
                @if ($category->children && $category->children->count() > 0)
                    <template class="cat-dropdown-tpl">
                        @foreach ($category->children as $sub)
                            <a href="{{ route('courses.search', ['category' => $category->slug, 'subcategory' => $sub->slug]) }}"
                                class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition-colors first:rounded-t-lg last:rounded-b-lg">
                                {{ $sub->name }}
                            </a>
                        @endforeach
                    </template>
                @endif
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdown = document.createElement('div');
            dropdown.className = [
                'fixed', 'z-[9999]', 'min-w-[210px]',
                'bg-white', 'border', 'border-gray-200',
                'rounded-xl', 'shadow-xl',
                'opacity-0', 'invisible', 'translate-y-1.5',
                'transition-all', 'duration-150', 'pointer-events-none'
            ].join(' ');
            document.body.appendChild(dropdown);

            let hideTimer = null;

            document.querySelectorAll('.category-item').forEach(function(item) {
                const tpl = item.querySelector('.cat-dropdown-tpl');
                if (!tpl) return;

                item.addEventListener('mouseenter', function() {
                    clearTimeout(hideTimer);
                    dropdown.innerHTML = tpl.innerHTML;

                    const rect = item.getBoundingClientRect();
                    dropdown.style.top = (rect.bottom + 4) + 'px';
                    dropdown.style.left = rect.left + 'px';

                    dropdown.classList.remove('opacity-0', 'invisible', 'translate-y-1.5',
                        'pointer-events-none');
                    dropdown.classList.add('opacity-100', 'visible', 'translate-y-0',
                        'pointer-events-auto');
                });

                item.addEventListener('mouseleave', () => {
                    hideTimer = setTimeout(hideDropdown, 120);
                });
            });

            dropdown.addEventListener('mouseenter', () => clearTimeout(hideTimer));
            dropdown.addEventListener('mouseleave', () => {
                hideTimer = setTimeout(hideDropdown, 120);
            });

            function hideDropdown() {
                dropdown.classList.remove('opacity-100', 'visible', 'translate-y-0', 'pointer-events-auto');
                dropdown.classList.add('opacity-0', 'invisible', 'translate-y-1.5', 'pointer-events-none');
            }
        });
    </script>
@endpush
