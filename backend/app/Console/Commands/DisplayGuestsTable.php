<?php

namespace App\Console\Commands;

use App\Models\Guest;
use Illuminate\Console\Command;

class DisplayGuestsTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'display:guests {guests=10}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display guests';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Usage: php artisan display:guests {xx}, 10 by default');

        $this->table(
            ['ID', 'Name', 'Companions', 'Package'],
            Guest::latest()->take($this->argument('guests'))->get(['id', 'name', 'companions', 'package_id'])->toArray()
        );

        $this->info(Guest::latest()->count().' new guest(s) added. Total guests: '.Guest::count());

        return Command::SUCCESS;
    }
}
