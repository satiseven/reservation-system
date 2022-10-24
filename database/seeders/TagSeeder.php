<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            "Toilet paper",
            "Towels",
            "Towels/Sheets (extra fee)",
            "Bathtub or shower"
            ,
            "Slippers"
            ,
            "Private Bathroom"
            ,
            "Toilet"
            ,
            "Free toiletries"
            ,
            "Bathrobe"
            ,
            "Hairdryer"
            ,
            "Bathtub"
            ,
            "nvoice provided"
            ,
            "Concierge"
            ,
            "Baggage storage"
            ,
            "Tour desk"
            ,
            "Currency exchange"
            ,
            "Express check-in/out"
            ,
            "24-hour front desk"
            ,
            "Fire extinguishers"
            ,
            "CCTV outside property"
            ,
            "CCTV in common areas"
            ,
            "Smoke alarms"
            ,
            "Key card access"
            ,
            "Key access"
            ,
            "24-hour security"
            ,
            "Safe"
            ,
            "Carbon monoxide detector"
            ,
            "Air conditioning"
            ,
            "Smoke-free property"
            ,
            "Wake-up service"
            ,
            "Heating"
            ,
            "Soundproof"
            ,
            "Car rental"
            ,
            "Laptop safe"
            ,
            "Interconnecting room(s) available"
            ,
            "Carpeted"
            ,
            "Soundproof rooms"
            ,
            "Elevator"
            ,
            "Family rooms"
            ,
            "Hair/Beauty salon"
            ,
            "Ironing facilities"
            ,
            "Iron"
            ,
            "Room service"
            ,
            "Locker rooms"
            ,
            "Fitness"
            ,
            "Spa/Wellness packages"
            ,
            "Spa lounge/Relaxation area"
            ,
            "Steam room"
            ,
            "Spa facilities"
            ,
            "Beach chairs/Loungers"
            ,
            "Hot tub/Jacuzzi"
            ,
            "Massage Additional charge"
            ,
            "Spa"
            ,
            "Fitness center"
            ,
            "Sauna"
            ,
            "Open all year"
            ,
            "Opening times"
            ,
            "Heated pool"
            ,
            "Pool/Beach towels"
            ,
            "Beach chairs/Loungers"
            ,
            "Board games/Puzzles",
        ];
        foreach ($tags as $tag) {
            Tag::create(['name' => $tag, 'slug' => Str::slug($tag)]);
        }
    }
}
