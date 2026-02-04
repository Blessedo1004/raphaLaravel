<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rooms')->insert([
            [
                'name' => 'Super Studio Room',
                'guest_number' => 2,
                'description' => 'Check into our Super Studio Rooms, where standard is combined with comfort. We are located at the State Secretariat environ, easily accessible from the city centre. Come and enjoy our serene environment, free from the usual hustle and bustle.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ambassador Suite',
                'guest_number' => 2,
                'description' => 'Check into our Ambassador Suite, where prestige is engrossed in comeliness and comfort. We are located at the State Secretariat environ which is easily accessible from the city. Come and enjoy the rich hospitality endeared by the serene environment devoid of the usual hustle and bustle.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Apartments',
                'guest_number' => 6,
                'description' => 'Check into our 2 Bedrooms Duplex Apartment, where you will experience real home from home experience and comfort. We are located at the State Secretariat environ which is easily accessible from the city. Come and savour true relaxation in complete privacy, devoid of the usual hustle and bustle.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Classic Room',
                'guest_number' => 2,
                'description' => 'Check into Classic Rooms, where class is cuddled with comfort. We are located at the State Secretariat environ which is easily accessible from the city centre. Come and have your relaxation without the usual hustle and bustle.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Exclusive Room',
                'guest_number' => 2,
                'description' => 'Check into our Exclusive Rooms, where beauty is seasoned with comfort. We are located at the State Secretariat environ, which is easily accessible from the city centre. Come and have your relaxation without the usual hustle and bustle.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Family Room',
                'guest_number' => 4,
                'description' => 'Check into our Family Rooms, where comeliness is cuddled in unity and comfort. We are located at the State Secretariat environ which is easily accessible from the city. Come and enjoy the serene atmosphere devoid of the usual hustle and bustle.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Banquet and Conference Hall',
                'guest_number' => 0,
                'description' => 'Rapha Hotel offers both small and large banquet halls, perfect for intimate gatherings or grand celebrations.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Luxury Room',
                'guest_number' => 2,
                'description' => 'Check into our Luxury Rooms, where luxury is married with sophistication and comfort. We are located at the State Secretariat environ which is easily accessible from the city. Come and catch the aesthetics and nature devoid of the usual hustle and bustle.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Premier Room',
                'guest_number' => 2,
                'description' => 'Check into Premier Rooms, where class is immersed in comeliness and comfort. We are located at the State Secretariat environ which is easily accessible from the city. Come and catch the fun you have been cut off from due to the usual hustle and bustle.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Presidential Suite',
                'guest_number' => 2,
                'description' => 'Check into our Presidential Suite, where prestige is wrapped in elegance and comfort. We are located at the State Secretariat environ which is easily accessible from the city. Come and savour unalloyed relaxation devoid of the usual hustle and bustle.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Update all rooms to set availability to 10
        Room::where('name', 'Apartments')->update(['availability' => 0]);
        Room::where('name', 'Luxury Room')->update(['availability' => 5]);
    }
}
