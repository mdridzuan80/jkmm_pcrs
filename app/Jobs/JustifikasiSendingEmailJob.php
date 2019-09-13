<?php

namespace App\Jobs;

use Mail;
use Flow;
use App\Anggota;
use App\Mail\JustifikasiMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class JustifikasiSendingEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $profil;
    private $finalAttendanceId;
    private $medanKesalahan;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Anggota $profil, $finalAttendanceId, $medanKesalahan)
    {
        $this->profil = $profil;
        $this->finalAttendanceId = $finalAttendanceId;
        $this->medanKesalahan = $medanKesalahan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return Mail::to(Flow::pelulus($this->profil)->xtraAttr->email)
            ->send(new JustifikasiMail($this->finalAttendanceId, $this->medanKesalahan));
    }
}
