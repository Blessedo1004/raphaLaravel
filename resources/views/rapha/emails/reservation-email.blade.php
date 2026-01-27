<x-head-two>
    <x-slot name="body">
     <img src="https://raphahotel.ng/images/logo-white1.webp" alt="logo" style="margin: auto; display:block;">
    <p style="text-align:center">Hello. Your reservation details :</p>
    <p style="text-align:center">Name : {{$reservation->user->last_name . ' ' . $reservation->user->first_name}}</p>
    <p style="text-align:center">Room Type : {{$reservation->room->name . ' ' . '|'. ' ' . $reservation->room->guest_number . ' Guests'}}</p>
    <p style="text-align:center">Check In Date : {{$reservation->check_in_date->format('F j, Y') }}</p>
    <p style="text-align:center">Check  Out Date : {{$reservation->check_out_date->format('F j, Y') }}</p>
    <p style="text-align:center">Number Of Rooms : {{$reservation->number_of_rooms}}</p>
    <p style="text-align:center">Reservation ID : {{$reservation->reservation_id}}</p>
    <p style="text-align:center">Expiry Date : {{$reservation->expires_at->format('F j, Y')}}</p>
    <p style="text-align:center">Please go to the rapha hotel counter before the expiry date and submit your reservation ID to check in.</p>
    </x-slot>
    
</x-head-two>