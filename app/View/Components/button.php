<?php

namespace App\View\Components;

use Illuminate\View\Component;

class button extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $url,$size,$title,$color;
    public function __construct($url,$size,$title,$color)
    {
        $this->url = $url;
        $this->size = $size;
        $this->title = $title;
        $this->color = $color;
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button');
    }
}
