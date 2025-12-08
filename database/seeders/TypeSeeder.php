<?php

namespace Database\Seeders;

use App\Models\TypeModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Nette\Utils\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // TypeModel::create([
        //     'name' => 'Deluxe',
        //     'description' => 'Experience elevated comfort in our Level 3 Deluxe Room, offering a serene view and a calm, private atmosphere. While it has no balcony, the room features two units with full glass windows, allowing natural light to fill the space and giving guests a bright and refreshing environment. Perfect for guests who enjoy a scenic outlook and a modern, cozy stay.',
        //     'price_per_night' => 650000
        // ]);

        // TypeModel::create([
        //     'name' => 'Studio',
        //     'description' => 'Our Studio Room, located on Level 1, is designed for simplicity and convenience. Although it has no view, it includes a private balcony where guests can relax and enjoy fresh outdoor air. Ideal for travelers seeking comfort, accessibility, and a peaceful escape on the ground level.',
        //     'price_per_night' => 850000
        // ]);

        // TypeModel::create([
        //     'name' => 'Mezzanine',
        //     'description' => 'The Mezzanine Room, located on Level 2, offers a unique and spacious two-floor layout. Complete with a balcony and a beautiful view, this room type is perfect for guests who appreciate stylish architecture and extra living space. Its elevated design creates a modern loft-like experience, making it one of our most distinctive room options.',
        //     'price_per_night' => 750000
        // ]);
    }
}
