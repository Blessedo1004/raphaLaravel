<x-user-layout title="Notifications">

  <x-slot name="content">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <h2>Notifications</h2>
                    <a href="{{ route('user-mark-all-as-read') }}" class="btn reg_btn text-white col-4 col-xl-3">Mark all as read</a>
                </div>

                @if($groupedNotifications->isEmpty())
                    <h4 class="text-center mt-4">No notifications found.</h4>
                @else
                 @foreach ($groupedNotifications as $date => $notificationsOnDate)
                  <div class="col-12 col-lg-10 bg-light mt-2">
                    <h3 class="text-center mt-5 date_heading">
                        @if(Carbon\Carbon::parse($date)->isToday())
                        Today
                        @elseif(Carbon\Carbon::parse($date)->isYesterday())
                        Yesterday
                        @else
                        {{ Carbon\Carbon::parse($date)->format('F j, Y') }}
                        @endif
                    </h3>
                    <ul class="list-group">
                        @foreach ($notifications as $notification)
                            <li class="list-group-item d-flex justify-content-between align-items-center @if(!$notification->read_at) bg-light @endif">
                                <div class="mx-auto d-block">
                                    Hello {{ $notification->data['last_name'] . ' ' . $notification->data['first_name']}}, your reservation with reservation ID {{ $notification->data['reservation_id']}} expires 2 hours from now. Please do well to checkout when the time comes.
                                </div>
                                @if(!$notification->read_at)
                                    <a href="{{ route('user-mark-as-read', $notification->id) }}" class="btn reg_btn text-white col-4">Mark as read</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                  </div>
                 @endforeach 
                @endif
            </div>
        </div>
    </div>
  </x-slot>
  
</x-user-layout>