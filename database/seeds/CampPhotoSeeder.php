<?php

use Illuminate\Database\Seeder;

use App\Camp;
use App\CampPhoto;

use Faker\Generator as Faker;

class CampPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = new Faker();

        $camps = Camp::all();

        foreach ($camps as $camp) {
            //Creating 3 pictures per camp
            for ($i = 0; $i <  3; $i++) {
                CampPhoto::create([
                    'url'   =>  'https://i.picsum.photos/id/' . random_int(100, 999) . '/500/500.jpg',
                    'camp_id'   =>  $camp->id
                ]);
            }
        }
    }
}
