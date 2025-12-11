<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bill;
use App\Models\Reading;
use Illuminate\Support\Str;

class BillSeeder extends Seeder
{
    public function run(): void
    {
        // Number of dummy bills you want to create
        $numberOfBills = 100;

        for ($i = 0; $i < $numberOfBills; $i++) {
            $previous = rand(50, 200);
            $present = $previous + rand(10, 100);
            $consumption = $present - $previous;
            $createdAt = now()->subDays(rand(1, 30));

            // Random account and zone data
            $accountNo = 'ACCT-' . strtoupper(Str::random(6));
            $zone = 'ZONE-' . rand(1, 10);

            // Create the reading first, temporarily without reference_no
            $reading = Reading::create([
                'zone'                => $zone,
                'account_no'          => $accountNo,
                'previous_reading'    => $previous,
                'present_reading'     => $present,
                'consumption'         => $consumption,
                'reader_name'         => fake()->name(),
                'isReRead'            => (bool) rand(0, 1),
                'reread_reference_no' => strtoupper(uniqid('RR')),
                'created_at'          => $createdAt,
                'updated_at'          => now(),
            ]);

            // Generate the formatted reference_no like NST-BCWD-YYMM000001
            $prefix = 'NST-BCWD-';
            $datePart = $createdAt->format('ym'); // YYMM format
            $numberPart = str_pad($reading->id, 6, '0', STR_PAD_LEFT); // zero-padded ID

            $referenceNo = $prefix . $datePart . $numberPart;

            // Update reading with the reference_no
            $reading->update([
                'reference_no' => $referenceNo
            ]);

            // Create bill linked to the reading with random data
            Bill::create([
                'reading_id'            => $reading->id,
                'reference_no'          => 'BILL-' . strtoupper(uniqid()),
                'bill_period_from'      => $createdAt->copy()->subMonth(),
                'bill_period_to'        => $createdAt,
                'amount'                => rand(500, 2000),
                'amount_after_due'      => rand(2000, 3000),
                'amount_paid'           => 0,
                'isPaid'                => false,
                'hasPenalty'            => (bool) rand(0, 1),
                'hasDisconnection'      => (bool) rand(0, 1),
                'hasDisconnected'       => (bool) rand(0, 1),
                'created_at'            => now(),
                'updated_at'            => now(),
            ]);
        }
    }
}
