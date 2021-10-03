<?php

namespace App\View\Components;

use Illuminate\View\Component;

class breadcrumb extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $title;
    public $subTitle;
    public $head;

    public function __construct($breadcrumb)
    {
        //
        $this->title= $breadcrumb['title'];
        $this->subTitle= $breadcrumb['subtitle'];
        $this->head= $breadcrumb['head'];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.breadcrumb');
    }
}
