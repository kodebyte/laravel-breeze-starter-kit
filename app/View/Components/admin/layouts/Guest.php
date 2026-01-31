<?php

namespace App\View\Components\Admin\Layouts;

use Illuminate\View\Component;
use Illuminate\View\View;

class Guest extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('admin.layouts.guest');
    }
}
