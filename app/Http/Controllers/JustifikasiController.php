<?php

namespace App\Http\Controllers;

use Auth;
use Flow;
use App\Anggota;
use App\Justifikasi;
use App\Base\BaseController;
use Illuminate\Http\Request;
use App\Jobs\JustifikasiSendingEmailJob;
use App\Http\Requests\JustifikasiRequest;

class JustifikasiController extends BaseController
{
    public function index()
    {
        $permohonan = Auth::user()->xtraAnggota->kelulusanJustifikasi()->get();

        return $this->renderView('kelulusan.index', compact('permohonan'));
    }

    public function rpcStore(JustifikasiRequest $request, Anggota $profil)
    {
        if (Flow::pelulus($profil)) {

            $justifikasi = [
                'finalattendance_id' => $request->input('finalAttendance'),
                'basedept_id' => $profil->xtraAttr->basedept_id,
                'tarikh' => $request->input('tarikh'),
                'flag_justifikasi' => $request->input('sama'),
                'alasan' => $request->input('alasan'),
                'pelulus_id' => Flow::pelulus($profil)->xtraAttr->anggota_id,
            ];

            if ($request->input('sama') == Justifikasi::FLAG_JUSTIKASI_SAMA) {
                $justifikasiPagi = new Justifikasi;
                $justifikasi['medan_kesalahan'] = Justifikasi::FLAG_MEDAN_KESALAHAN_PAGI;
                $justifikasiPagi->simpan($justifikasi);

                $justifikasiPetang = new Justifikasi;
                $justifikasi['medan_kesalahan'] = Justifikasi::FLAG_MEDAN_KESALAHAN_PETANG;
                $justifikasiPetang->simpan($justifikasi);

                dispatch(new JustifikasiSendingEmailJob($profil, $request->input('finalAttendance'), $request->input('medanKesalahan')));

                return response('Ok', 200);
            }

            $justifikasiA = new Justifikasi;
            $justifikasi['medan_kesalahan'] = $request->input('medanKesalahan');
            $justifikasiA->simpan($justifikasi);

            dispatch(new JustifikasiSendingEmailJob($profil, $request->input('finalAttendance'), $request->input('medanKesalahan')));

            return response('Ok', 200);
        }

        return response('Sila semak konfigurasi flow anggota atau ketua jabatan', 422);
    }

    public function rpcUpdate(Justifikasi $justifikasi, Request $request)
    {
        $justifikasi->flag_kelulusan = $request->input('status');
        $justifikasi->save();
    }
}
