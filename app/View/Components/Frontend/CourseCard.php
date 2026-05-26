<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CourseCard extends Component
{
    public $course;

    public $badge;

    /**
     * Create a new component instance.
     */
    public function __construct($course, $badge = null)
    {
        $this->course = $course;
        $this->badge = $badge;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('frontend.components.course-card');
    }
}
