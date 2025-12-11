<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Bill;
use App\Models\ConcessionerAccount;
use Faker\Factory as Faker;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $bills = Bill::all();
        $accounts = ConcessionerAccount::all();

        if ($bills->isEmpty() || $accounts->isEmpty()) {
            $this->command->info('No bills or concessioner accounts found. Seeder aborted.');
            return;
        }

        for ($i = 0; $i < 100; $i++) {
            $bill = $bills->random();
            $account = $accounts->random();

            $amount = $faker->randomFloat(2, 100, 2000);
            $fee = round($amount * 0.015, 2);   // 1.5% fee example
            $net = $amount - $fee;

            Transaction::create([
                'bill_id'           => $bill->id,
                'account_id'        => $account->id,
                'reference_no'      => strtoupper('REF-' . $faker->unique()->bothify('#######')),
                'gateway_payment_id'=> strtoupper('PAY-' . $faker->unique()->bothify('########')),
                'payment_method'    => $faker->randomElement(['gcash', 'bank', 'hitpay']),
                'amount'            => $amount,
                'fee'               => $fee,
                'net_amount'        => $net,
                'status'            => 'paid',
                'paid_at'           => Carbon::now()->subDays(rand(1, 30)),
            ]);
        }
    }
}
