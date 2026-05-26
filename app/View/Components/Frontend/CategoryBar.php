<?php

namespace App\View\Components\Frontend;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class CategoryBar extends Component
{
    public $categories;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->categories = Cache::remember('category_bar_categories', 3600, function () {
            return Category::with('children')
                ->where('status', 1)
                ->whereNull('parent_id')
                ->limit(8)
                ->get(['id', 'name', 'slug']);
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('frontend.components.category-bar');
    }
}
