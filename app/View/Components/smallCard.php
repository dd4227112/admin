<?php

namespace App\View\Components;

use Illuminate\View\Component;

class smallCard extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $title,$value,$icon,$cardcolor;
    public function __construct($title,$value,$icon,$cardcolor)
    {
        $this->title = $title;
        $this->value = $value;
        $this->icon = $icon;
        $this->cardcolor = $cardcolor;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.small-card');
    }
}
