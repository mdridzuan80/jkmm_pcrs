<?php

namespace App\Http\Controllers;

use Auth;
use Flow;
use App\Acara;
use App\Anggota;
use App\Base\BaseController;
use Illuminate\Http\Request;
use App\Repositories\Justifikasi;
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
            $tarikh = substr($request->input('tarikh'), 0, 10);
            $dataJustifikasiPagi = [
                'finalattendance_id' => $request->input('finalAttendance'),
                'basedept_id' => $profil->xtraAttr->basedept_id,
                'tarikh_mula' =>  $tarikh . " 07:30",
                'tarikh_tamat' =>  $tarikh . " 09:00",
                'flag_justifikasi' => $request->input('sama'),
                'alasan' => $request->input('alasan'),
                'pelulus_id' => Flow::pelulus($profil)->xtraAttr->anggota_id,
                'kategori' => Acara::KATEGORI_JUSTIFIKASI
            ];

            $dataJustifikasiPetang = [
                'finalattendance_id' => $request->input('finalAttendance'),
                'basedept_id' => $profil->xtraAttr->basedept_id,
                'tarikh_mula' =>  $tarikh . " 13:00",
                'tarikh_tamat' =>  $tarikh . " 18:00",
                'flag_justifikasi' => $request->input('sama'),
                'alasan' => $request->input('alasan'),
                'pelulus_id' => Flow::pelulus($profil)->xtraAttr->anggota_id,
                'kategori' => Acara::KATEGORI_JUSTIFIKASI
            ];

            if ($request->input('sama') == Justifikasi::FLAG_JUSTIKASI_SAMA) {
                $justifikasiPagi = new Justifikasi;
                $dataJustifikasiPagi['medan_kesalahan'] = Justifikasi::FLAG_MEDAN_KESALAHAN_PAGI;
                //$justifikasiPagi->simpan($dataJustifikasiPagi);

                $justifikasiPetang = new Justifikasi;
                $dataJustifikasiPetang['medan_kesalahan'] = Justifikasi::FLAG_MEDAN_KESALAHAN_PETANG;
                //$justifikasiPetang->simpan($justifikasi);

                if ($justifikasiPagi->simpan($dataJustifikasiPagi) && $justifikasiPetang->simpan($dataJustifikasiPetang)) {
                    dispatch(new JustifikasiSendingEmailJob(
                        $profil,
                        $request->input('finalAttendance'),
                        $request->input('medanKesalahan')
                    ));

                    return response('Ok', 200);
                }

                return response('Data conflict', 409);
            }

            $justifikasiA = new Justifikasi;
            $justifikasi['medan_kesalahan'] = $request->input('medanKesalahan');

            if ($request->input('medanKesalahan') == Justifikasi::FLAG_MEDAN_KESALAHAN_PAGI) {
                $justifikasi = $dataJustifikasiPagi;
            }
            if ($request->input('medanKesalahan') == Justifikasi::FLAG_MEDAN_KESALAHAN_PETANG) {
                $justifikasi = $dataJustifikasiPetang;
            }

            if ($justifikasiA->simpan($justifikasi)) {
                dispatch(new JustifikasiSendingEmailJob(
                    $profil,
                    $request->input('finalAttendance'),
                    $request->input('medanKesalahan')
                ));

                return response('Ok', 200);
            }

            return response('Data conflict', 409);
        }

        return response('Sila semak konfigurasi flow anggota atau ketua jabatan', 422);
    }

    public function rpcUpdate(Justifikasi $justifikasi, Request $request)
    {
        $justifikasi->flag_kelulusan = $request->input('status');
        $justifikasi->save();
    }
}
