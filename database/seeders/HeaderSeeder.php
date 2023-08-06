<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Header;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Header::create([
            'sc_facebook' => Str::random(10),
            'sc_linkedin' => Str::random(10),
            'sc_instagram' => Str::random(10),
            'sc_youtube' => Str::random(10),
            'sc_twitter' => Str::random(10),
            'sc_whatsapp' => Str::random(10),
            'sc_email' => Str::random(10),
            'logo_image' => Str::random(10),
            'logo_name' => Str::random(10),
        ]);

    }
}
