<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\Camp;
use App\CampPayment;
use App\User;
use App\Bank;
use App\PaymentMethod;

use Faker\Generator as Faker;

class CampPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = new Faker();

        //Get all camps
        $camps = Camp::all();

        //Get all banks ids
        $banks_ids = Bank::pluck('id')->toArray();

        //Get all users ids
        $users_ids = User::pluck('id')->toArray();

        //Get all camp payment methods ids
        $payment_methods_ids = PaymentMethod::pluck('id')->toArray();

        foreach ($camps as $camp) {
            //Setting the starting date 2 weeks before the date setted in camp
            $starting_date = Carbon::create($camp->date)->subWeek(2)->toDateTimeString();
            $start = strtotime($starting_date);

            $end = strtotime($camp->date);

            //Fill as much payments as camp entries.
            for($i = 0; $i < $camp->entries; $i++) {
                //Get random bank id
                $rand_bank_id = $banks_ids[array_rand($banks_ids)];

                //Get random user id
                $rand_user_id = $users_ids[array_rand($users_ids)];

                //Get random payment id
                $rand_payment_method_id = $payment_methods_ids[array_rand($payment_methods_ids)];

                //Set the date by mt_rand
                $timestamp = mt_rand($start, $end);
                $rand_date = date('Y-m-d H:i:s', $timestamp);

                //Create new camp payment row
                CampPayment::create([
                    'reference' =>  random_int(10000, 99999),
                    'photo'     =>  'https://i.picsum.photos/id/' . random_int(100, 999) . '/500/500.jpg',
                    'date'      =>  $rand_date,
                    'validated' =>  random_int(0, 1),
                    'payment_method_id' =>  $rand_payment_method_id,
                    'camp_id'   =>  $camp->id,
                    'user_id'   =>  $rand_user_id,
                    'bank_id'   =>  $rand_bank_id,
                ]);
            }
        }
    }
}
