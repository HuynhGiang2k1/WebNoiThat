<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Money extends Component
{
    public $amount;
    public $currency;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($amount, $currency = '₫')
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.money');
    }
}
