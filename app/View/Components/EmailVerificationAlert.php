<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class EmailVerificationAlert extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }
 public function shouldDisplay(): bool
    {
        return Auth::check() && ! Auth::user()->hasVerifiedEmail();
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.email-verification-alert');
    }
}
