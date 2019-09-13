<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\FinalAttendance;

class JustifikasiMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    var $finalAttendance;
    var $justifikasi;

    public function __construct($finalattendance_id, $medan_kesalahan)
    {
        $this->finalAttendance = FinalAttendance::find($finalattendance_id);
        $this->justifikasi = $this->finalAttendance->justifikasi()
            ->where('medan_kesalahan', $medan_kesalahan)->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('[' . env('APP_SHORT_NAME') . '] Permohonan Justifikasi oleh ' . $this->finalAttendance->anggota->nama)
            ->view('mails.justifikasi')
            ->with([
                'nama' => $this->finalAttendance->anggota->nama,
                'justifikasi' => $this->justifikasi,
            ]);
    }
}
