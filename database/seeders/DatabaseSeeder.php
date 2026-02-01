<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        DB::table('polls')->insert([
            'question' => 'Who is the best cricketer?',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('poll_options')->insert([
            ['poll_id'=>1,'option_text'=>'Virat Kohli'],
            ['poll_id'=>1,'option_text'=>'MS Dhoni'],
            ['poll_id'=>1,'option_text'=>'Rohit Sharma'],
        ]);
    }
}
