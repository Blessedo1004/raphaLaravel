<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Room;

class DSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $room =  Room::where('id',7);
       $room->update([
        "guest_number" =>"Multiple Guests"
       ]);
    }
}
