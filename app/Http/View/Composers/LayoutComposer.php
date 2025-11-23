<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class LayoutComposer
{
    public function compose(View $view)
    {
        if (Auth::check()) {
            $notificationCount = Auth::user()->unreadNotifications->count();
            $view->with('notificationCount', $notificationCount);
        }
    }
}
