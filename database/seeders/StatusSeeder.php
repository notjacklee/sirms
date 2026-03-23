<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['New', 'In Review', 'Assigned', 'Resolved', 'Closed', 'Invalid'];
        $now = Carbon::now();

        foreach ($statuses as $s) {
            DB::table('statuses')->updateOrInsert(
                ['name' => $s],
                ['created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
