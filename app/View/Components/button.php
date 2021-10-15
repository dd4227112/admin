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
    public $url,$btnsize,$title,$color,$shape,$toggleTitle;
    public function __construct($url,$btnsize,$title,$color,$shape,$toggleTitle)
    {  
       // $this->url = $url;
        dd($btnsize);

        $this->btnsize = $btnsize;
        $this->title = $title;
        $this->color = $color;
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
