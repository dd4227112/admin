<?php

namespace App\View\Components;

use Illuminate\View\Component;

class analyticCard extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name,$value,$icon,$color,$topicon,$subtitle;

    public function __construct($name,$value,$icon,$color,$topicon,$subtitle)
    {
        $this->name = $name;
        $this->value = $value;
        $this->icon = $icon;
        $this->color = $color;
        $this->topicon=$topicon;
        $this->subtitle=$subtitle;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.analytic-card');
    }
}
