<?php

namespace App\View\Components\ShortCourseManagement;

use Illuminate\View\Component;

class AddParticipant extends Component
{

    public Object $event;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        //

        $this->event = $event;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('short-course-management.components.add-participant');
    }
}
