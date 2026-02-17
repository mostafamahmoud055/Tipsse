<?php

namespace App\View\Components\ecommerce;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardSection extends Component
{

    public function __construct(public string $title){}

    public function render()
    {
        return view('components.tipssestate.card-section');
    }
}