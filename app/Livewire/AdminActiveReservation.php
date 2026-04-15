<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\ActiveReservation;
use App\Models\CompletedReservation;
use App\Models\Room;


class AdminActiveReservation extends Component
{
    use WithPagination;
    #[Layout('layouts.layout')]
    protected $paginationTheme = 'bootstrap';

    public $searchTerm;
    public $modalShow = false;
    public $details;

    public function showDetails ($id){
        $this->details = ActiveReservation::withoutGlobalScope('user')->with('user','room')->findOrFail($id);
        $this->modalShow = true;
    }

    public function closeModal (){
        $this->modalShow = false;
    }

    public function checkOut($id){
        $checkout = ActiveReservation::withoutGlobalScope('user')->findOrFail($id);
        CompletedReservation::create([
            "user_id" => $checkout->user_id,
            "room_id" => $checkout->room_id,
            "check_in_date" => $checkout->check_in_date,
            "check_out_date" => $checkout->check_out_date,
            "reservation_id" => $checkout->reservation_id,
            "number_of_rooms" => $checkout->number_of_rooms
        ]);

        $room = Room::findOrFail($checkout->room_id);
        $room->update(['availability' => $room->getOriginal('availability') + $checkout->number_of_rooms]);
        session()->flash('checkout-success', 'Check Out Successful');

        $this->redirect('/admin/completed', navigate: true);
    }

    public function render()
    {
        if($this->searchTerm){
            $reservations = ActiveReservation::withoutGlobalScope('user')->with(['user:id,first_name,last_name','room:id,name'])->select(['id', 'user_id' , 'room_id', 'created_at'])->where('reservation_id', 'LIKE', "%{$this->searchTerm}%")->get();
            return view('livewire.admin-active-reservation', compact('reservations'));
        }
        $reservations = ActiveReservation::withoutGlobalScope('user')->with(['user:id,first_name,last_name','room:id,name'])->select(['id', 'user_id' , 'room_id', 'created_at'])->orderBy('id', 'desc')->paginate(10)->onEachSide(0);
        return view('livewire.admin-active-reservation', compact('reservations'));
    }
}
