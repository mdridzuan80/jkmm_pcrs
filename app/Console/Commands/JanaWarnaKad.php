<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use WarnaKad;
use Illuminate\Console\Command;

class JanaWarnaKad extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "emasa:janawarnakad {users?*} {--tarikh=first day of last month}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'menjana warna kad mengikut polisi yang berkaitan';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tarikh = Carbon::parse($this->option('tarikh'));

        $this->info('Janaan bermula...');

        $usersCollection = collect($this->argument('users'));

        WarnaKad::janaWarnaKadConsole($usersCollection, $tarikh);

        $this->info('Janaan Tamat');
    }
}
