<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            'New',
            'Assigned',
            'In Review',
            'Rejected',
            'Resubmitted',
            'Resolved',
            'Closed'
        ];

        $now = Carbon::now();

        foreach ($statuses as $status) {
            DB::table('statuses')->updateOrInsert(
                ['name' => $status],
                [
                    'created_at' => $now,
                    'updated_at' => $now
                ]
            );
        }
    }
}