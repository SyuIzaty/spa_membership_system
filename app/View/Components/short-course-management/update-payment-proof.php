<?php

namespace App\View\Components\short-course-management;

use Illuminate\View\Component;

class update-payment-proof extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.short-course-management.update-payment-proof');
    }
}
