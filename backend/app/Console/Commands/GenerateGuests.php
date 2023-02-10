<?php

namespace App\Console\Commands;

use App\Models\Guest;
use Illuminate\Console\Command;

class GenerateGuests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:guests {guests=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Guests';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $numberOfGuests = $this->argument('guests');
        $mockData = [];

        for ($i = 1; $i <= $numberOfGuests; $i++) {
            $companion = mt_rand(0, 5);
            $mockData[] = [
                'id' => $i,
                'companions' => $companion,
                'name' => 'fakename_'.$i,
                'package_id' => mt_rand(1, 5),
            ];
        }

        Guest::insert($mockData);
        $this->info(json_encode($mockData, JSON_PRETTY_PRINT));
    }
}
