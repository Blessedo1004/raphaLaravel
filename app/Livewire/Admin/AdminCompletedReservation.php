<?php

namespace App\Livewire\Admin;

use App\Models\CompletedReservation;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class AdminCompletedReservation extends Component
{
    use WithPagination;
    #[Layout('layouts.layout')]
    protected $paginationTheme = 'bootstrap';

    public $searchTerm;
    public $modalShow = false;
    public $details;

    public function showDetails ($id){
        $this->details = CompletedReservation::withoutGlobalScope('user')->with('user','room')->findOrFail($id);
        $this->modalShow = true;
    }

    public function closeModal (){
        $this->modalShow = false;
    }

    public function render()
    {
        if($this->searchTerm){
            $reservations = CompletedReservation::withoutGlobalScope('user')->with(['user:id,first_name,last_name','room:id,name'])->select(['id', 'user_id' , 'room_id', 'created_at'])->where('reservation_id', 'LIKE', "%{$this->searchTerm}%")->get();
            return view('livewire.admin.completed-reservation', compact('reservations'));
        }
        $reservations = CompletedReservation::withoutGlobalScope('user')->with(['user:id,first_name,last_name','room:id,name'])->select(['id', 'user_id' , 'room_id', 'created_at'])->orderBy('id', 'desc')->paginate(10)->onEachSide(0);
        return view('livewire.admin.completed-reservation', compact('reservations'));
    }
}
