<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use FinalAttendance;
use Illuminate\Console\Command;

class JanaFinalAttCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emasa:janafinalatt {users?*} {--mula=yesterday} {--tamat=yesterday} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menjana final attendance';

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
        $mula = Carbon::parse($this->option('mula'));
        $tamat = Carbon::parse($this->option('tamat'));

        if ($mula->greaterThan($tamat)) {
            $this->error('[ Ralat ] Pastikan tarikh mula lebih kecil atau sama dengan tarikh tamat.');
            return;
        }

        $this->info('Janaan bermula...');

        $usersCollection = collect($this->argument('users'));

        FinalAttendance::janaFinalAttendanceConsole($usersCollection, $mula, $tamat, $this);

        $this->info('Janaan Tamat');
    }
}
