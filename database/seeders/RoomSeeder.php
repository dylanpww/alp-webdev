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
        RoomModel::create([
            'room_number' => '101',
            'price_per_night' => 750000,
            'is_booked' => false,
            'description' => 'Kamar Deluxe dengan pemandangan laut yang indah.',
            'capacity' => 2,
            'type_id' => 1,
        ]);

        RoomModel::create([
            'room_number' => '102',
            'price_per_night' => 750000,
            'is_booked' => false,
            'description' => 'Kamar Deluxe dengan pemandangan laut.',
            'capacity' => 2,
            'type_id' => 1,
        ]);

        RoomModel::create([
            'room_number' => '103',
            'price_per_night' => 750000,
            'is_booked' => false,
            'description' => 'Kamar Deluxe dengan fasilitas lengkap.',
            'capacity' => 2,
            'type_id' => 1,
        ]);

        RoomModel::create([
            'room_number' => '104',
            'price_per_night' => 850000,
            'is_booked' => false,
            'description' => 'Kamar Premium dengan pemandangan taman.',
            'capacity' => 3,
            'type_id' => 2,
        ]);

        RoomModel::create([
            'room_number' => '105',
            'price_per_night' => 850000,
            'is_booked' => false,
            'description' => 'Kamar Premium dengan balkon pribadi.',
            'capacity' => 3,
            'type_id' => 2,
        ]);

        RoomModel::create([
            'room_number' => '106',
            'price_per_night' => 850000,
            'is_booked' => false,
            'description' => 'Kamar Premium cocok untuk keluarga kecil.',
            'capacity' => 3,
            'type_id' => 2,
        ]);

        RoomModel::create([
            'room_number' => '107',
            'price_per_night' => 1200000,
            'is_booked' => false,
            'description' => 'Suite Room dengan ruang tamu dan pemandangan kota.',
            'capacity' => 4,
            'type_id' => 3,
        ]);

        RoomModel::create([
            'room_number' => '108',
            'price_per_night' => 1200000,
            'is_booked' => false,
            'description' => 'Suite Room dengan fasilitas mewah dan bathtub.',
            'capacity' => 4,
            'type_id' => 3,
        ]);
    }
}
