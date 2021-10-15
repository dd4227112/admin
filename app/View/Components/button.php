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
    public $url,$color,$title,$shape,$toggleTitle,$btnsize;
    public function __construct($color,$title,$btnsize='mini',$shape='',$toggleTitle='',$url='')
    {  
        $this->url = $url;
        $this->btnsize = $btnsize;
        $this->color = $color;
        $this->title = $title;
        $this->shape = $shape;
        $this->toggleTitle = $toggleTitle;
        
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
