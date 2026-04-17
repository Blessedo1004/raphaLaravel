<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\ActiveReservation;
use App\Models\PendingReservation;
use Illuminate\Support\Facades\Auth;


class AdminPendingReservation extends Component
{
    use WithPagination;
    #[Layout('layouts.layout')]
    protected $paginationTheme = 'bootstrap';

    
    public $searchTerm;
    public $modalShow = false;
    public $details;
    public $userId;
    public $showNotification = false;

    public function getListeners()
    {
        return [
            "echo-private:pending-reservation.{$this->userId},.PendingReservationEvent"
                => 'handleNewReservation',
        ];
    }

    public function handleNewReservation()
    {
        $this->showNotification = true;
    }

    // public function refreshList()
    // {
    //     $this->showNotification = false;

    // }

    public function showDetails ($id){
        $this->details = PendingReservation::withoutGlobalScope('user')->with('user','room')->findOrFail($id);
        $this->modalShow = true;
    }

    
    public function closeModal (){
        $this->modalShow = false;
    }


    public function checkIn($id){
        $checkin = PendingReservation::withoutGlobalScope('user')->findOrFail($id);
        ActiveReservation::create([
            "user_id" => $checkin->user_id,
            "room_id" => $checkin->room_id,
            "check_in_date" => $checkin->check_in_date,
            "check_out_date" => $checkin->check_out_date,
            "reservation_id" => $checkin->reservation_id,
            "number_of_rooms" => $checkin->number_of_rooms
        ]);

        $checkin->delete();
        session()->flash('checkin-success', 'Check In Successful');

        $this->redirect('/admin/reservations/active', navigate: true);
    }

        public function mount()
    {
        $this->userId = Auth::id();
    }

    public function render()
    {

        if($this->searchTerm){
            $reservations = PendingReservation::withoutGlobalScope('user')->with(['user:id,first_name,last_name','room:id,name'])->select(['id', 'user_id' , 'room_id', 'created_at'])->where('reservation_id', 'LIKE', "%{$this->searchTerm}%")->get();
            return view('livewire.admin.pending-reservation', compact('reservations'));
        }

        $reservations = PendingReservation::withoutGlobalScope('user')->with(['user:id,first_name,last_name','room:id,name'])->select(['id', 'user_id' , 'room_id', 'created_at'])->orderBy('id', 'desc')->paginate(10)->onEachSide(0);
        return view('livewire.admin.pending-reservation', compact('reservations'));
    }
}
