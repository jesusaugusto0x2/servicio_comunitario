<?php
use App\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $methods = [
            'Transferencia', 'Depósito', 'Efectivo'
        ];

        foreach ($methods as $m) {
            PaymentMethod::create([
                'name' => $m
            ]);
        }
    }
}
