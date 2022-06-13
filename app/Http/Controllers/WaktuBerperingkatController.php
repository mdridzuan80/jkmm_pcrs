<?php

namespace App\Http\Controllers;

use App\Shift;
use App\Anggota;
use Carbon\Carbon;
use WaktuBerperingkat;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Base\BaseController;
use League\Fractal\Resource\Item;
use App\Transformers\ShiftTransformer;
use App\Http\Requests\StoreShiftRequest;
use App\Transformers\WaktuBekerjaTransformer;
use League\Fractal\Resource\Collection as FCollection;

class WaktuBerperingkatController extends BaseController
{
    public function rpcIndex(Anggota $profil)
    {
        
		//$list_acara = Acara::orderBy('id', 'desc')->get();
		
		$shifts = Shift::where('status', 'aktif')
		->orderBy('susunan', 'asc')->get();
		//$shifts = Shift::all()->sortBy('susunan');
        return view('anggota.waktu_bekerja.index', compact('shifts', 'profil'));
    }

    public function rpcBulanan(Manager $fractal, WaktuBekerjaTransformer $WaktuBekerjaTransformer, Anggota $profil, $tahun)
    {
        $shifts = $profil->shifts()
            ->whereYear('anggota_shift.tkh_mula', $tahun)
            ->orderBy('anggota_shift.tkh_mula')
            ->get();

        $resource = new FCollection($shifts, $WaktuBekerjaTransformer);
        $transform = $fractal->createData($resource);

        return response()->json($transform->toArray());
    }

    public function rpcBulananCreate(Request $request, Anggota $profil)
    {
        $tahun = $request->input('comTahun');
        $CBulan = collect($request->input('comBulan'));
        $shift = Shift::find($request->input('comWbb'));

        return WaktuBerperingkat::createBulanan($profil, $CBulan, $tahun, $shift);
    }

    public function rpcHarianCreate(Request $request, Anggota $profil)
    {
        $tkhMula = Carbon::parse($request->input('txtTarikhMula'));
        $tkhTamat = Carbon::parse($request->input('txtTarikhTamat'));
        $shift = Shift::find($request->input('comWbb'));

        return WaktuBerperingkat::createHarian($profil, $tkhMula, $tkhTamat, $shift);
    }

    public function rpcDelete(Anggota $profil, $waktuBekerjaId)
    {
        return WaktuBerperingkat::hapus($profil, $waktuBekerjaId);
    }

    public function rcpGridWaktuBekerja()
    {
        $perPage = 10;

        $shifts = Shift::whereNull('deleted_at')->paginate($perPage);

        return view('waktu_bekerja.index', compact('shifts'));
    }

    public function rcpWaktuBekerja(Shift $shift, Manager $fractal, ShiftTransformer $WaktuBekerjaTransformer)
    {
        $resource = new Item($shift, $WaktuBekerjaTransformer);
        $transform = $fractal->createData($resource);

        return response()->json($transform->toArray());
    }

    public function rcpTambahWaktuBekerja(StoreShiftRequest $request)
    {
        $shift = new Shift();
        $shift->name = $request->input('txtPerihal');
        $shift->check_in = Carbon::parse($request->input('txtWaktuMula'));
        $shift->check_out = Carbon::parse($request->input('txtWaktuTamat'));
        $shift->save();
    }
	
	
	public function rcpUpdateWaktuBekerja($waktuBekerja, Request $request)
    {
        $waktuBekerja = Shift::find($waktuBekerja);
        $waktuBekerja->name = $request->input('data.name');
        $waktuBekerja->check_in = $request->input('data.starttime');
        $waktuBekerja->check_out = $request->input('data.endtime');
        $waktuBekerja->save();
    }

    public function rcpHapusWaktuBekerja(Shift $shift)
    {
        $shift->delete();
    }
}
