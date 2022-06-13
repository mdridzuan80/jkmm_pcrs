<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Department;
use Illuminate\Console\Command;
use App\Repositories\LaporanRepository;

class laporankehadiran extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emasa:laporankehadiran {bahagian=all} {tarikh=yesterday} {jenis=penuh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'menghantar laporan kehadiran';

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
        $argBahagian = $this->argument('bahagian');
        $tarikh = Carbon::parse($this->argument('tarikh'));

        if ($this->argument('bahagian') == 'all') {
            $departments = Department::get();
        } else {
            $departments = Department::where('deptid', $argBahagian)->get();
        }

        foreach ($departments as $department) {
            $rekod = (new LaporanRepository)->laporanHarian($department->deptid, $tarikh->format('Y-m-d'));
        }
    }
}
