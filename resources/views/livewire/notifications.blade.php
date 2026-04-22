<?php

use Livewire\Component;

new class extends Component
{
   public $showNotification = false;
   public $userId;

    public function getListeners()
    {
        return [
            "echo-private:notification.{$this->userId},.NotificationEvent"
                => 'handleNewNotification',
        ];
    }

        public function handleNewNotification()
    {
        $this->showNotification = true;
    }

         public function mount()
    {
        $this->userId = Auth::id();
    }

        public function with(): array
    {

        $notificationCount = Auth::user()->unreadNotifications->count();
        return [
            'notificationCount' => $notificationCount,
        ];
    }    
};
?>

<div class="col-5 col-md-3 col-lg-12 text-center">
    <x-nav :activePage="Route::currentRouteName()" page="user-notifications">
        <i class="fa-solid fa-bell"></i> Notifications @if($notificationCount && $notificationCount > 0) <span class="badge bg-danger">{{ $notificationCount }}</span> @endif
    </x-nav>
</div>