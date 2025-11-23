<x-head-two>
    <x-slot name="body">
     <img src="https://raphahotel.ng/images/logo-white1.webp" alt="logo" style="margin: auto; display:block;">
    <p style="text-align:center">Hello {{$reservation->user->last_name . ' ' . $reservation->user->first_name}}, your reservation with reservation ID {{$reservation->reservation_id}}'s checkout date is 2 hours from now. Please do well to checkout when the time comes.</p>
    <p style="text-align:center">Regards, Rapha Hotel Admin</p>
    </x-slot>
    
</x-head-two>