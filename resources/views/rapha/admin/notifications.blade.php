<x-user-layout title="Notifications">

  <x-slot name="content">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <h2>Notifications</h2>
                    <a href="{{ route('admin-mark-all-as-read') }}" class="btn reg_btn text-white">Mark all as read</a>
                </div>

                @if($notifications->isEmpty())
                    <h4 class="text-center">No notifications found.</h4>
                @else
                    <ul class="list-group">
                        @foreach ($notifications as $notification)
                            <li class="list-group-item d-flex justify-content-between align-items-center @if(!$notification->read_at) bg-light @endif">
                                <div>
                                    User {{ $notification->data['user_name'] }} with reservation ID {{ $notification->data['reservation_id']}} is checkout date is today.
                                </div>
                                @if(!$notification->read_at)
                                    <a href="{{ route('admin-mark-as-read', $notification->id) }}" class="btn reg_btn text-white">Mark as read</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
  </x-slot>
  
</x-user-layout>