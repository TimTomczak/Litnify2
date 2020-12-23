<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MediumCard extends Component
{
    private $medium;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($medium)
    {
        $this->medium = $medium;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.medium-card',[
            'medium' => $this->medium,
        ]);
    }
}
