<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RoomModel;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for ($i = 101; $i <= 108; $i++) {
            RoomModel::create([
                'room_number' => (string) $i,
                'is_booked' => false,
                'capacity' => 2,
                'type_id' => 1, 
            ]);
        }

        for ($i = 201; $i <= 208; $i++) {
            RoomModel::create([
                'room_number' => (string) $i,
                'is_booked' => false,
                'capacity' => 2,
                'type_id' => 2,
            ]);
        }

        for ($i = 301; $i <= 308; $i++) {
            RoomModel::create([
                'room_number' => (string) $i,
                'is_booked' => false,
                'capacity' => 2,
                'type_id' => 3,
            ]);
        }
    }
}
