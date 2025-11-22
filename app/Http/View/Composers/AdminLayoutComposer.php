<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AdminLayoutComposer
{
    public function compose(View $view)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $notificationCount = Auth::user()->unreadNotifications->count();
            $view->with('notificationCount', $notificationCount);
        }
    }
}
