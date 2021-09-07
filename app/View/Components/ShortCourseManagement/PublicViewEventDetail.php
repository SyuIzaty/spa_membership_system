<?php

namespace App\View\Components\ShortCourseManagement;

use Illuminate\View\Component;

class PublicViewEventDetail extends Component
{

    public Object $event;
    public $errors;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($event, $errors)
    {
        //

        $this->event = $event;
        $this->errors = $errors;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('short-course-management.components.public-view-event-detail');
    }
}
