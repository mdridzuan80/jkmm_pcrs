<?php

namespace App\Http\Controllers;

use App\Puasa;
use App\Utility;
use App\Anggota;
use App\ShiftConf;
use League\Fractal\Manager;
use App\Base\BaseController;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use App\Transformers\Anggota as AnggotaTransformer;
use League\Fractal\Resource\Collection as FCollection;

class AnggotaController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->renderView('anggota.index');
    }

    public function rpcAnggotaGrid(Request $request)
    {
        $search = collect([
            'key' => $request->input('searchKey'),
            'dept' => Utility::pcrsListerDepartment($request->input('subDept'), $request->input('searchDept')),
        ]);

        $perPage = 10;
        $senAnggota = Anggota::senaraiAnggota($search)
            ->paginate($perPage);

        return view('anggota.anggota_grid', compact('senAnggota'));
    }

    public function rpcAnggotaPenilaiGrid(Request $request, Manager $fractal, AnggotaTransformer $anggotaTransformer)
    {
        $search = collect([
            'key' => $request->input('searchKey'),
            'dept' => Utility::pcrsListerDepartment($request->input('subDept'), $request->input('searchDept')),
        ]);

        $resource = new FCollection(Anggota::SenaraiAnggota($search)->get(), $anggotaTransformer);
        $transform = $fractal->createData($resource);

        return response()->json($transform->toArray());
    }

    public function rpcShow(Anggota $profil)
    {
        return view('anggota.profil.show', compact('profil'));
    }

    public function rpcUpdate(Request $request, Anggota $profil)
    {
        $profil->kemaskiniProfil($request);
    }

    // Pegawai Penilai
    public function rpcPenilaiIndex(Anggota $profil)
    {
        $penilai = optional(($profil->pegawaiPenilai()->with('penilai')->get()))->mapToGroups(function ($item, $key) {
            return [$item->pegawai_flag => $item->penilai];
        });

        return view('anggota.penilai.index', compact('profil', 'penilai'));
    }

    public function rpcPenilaiUpdate(Request $request, Anggota $profil)
    {
        $profil->kemaskiniPPP($request);
    }

    public function rpcBaseBahagianShow(Anggota $profil)
    {
        return view('anggota.base_bahagian.show', compact('profil'));
    }

    public function rpcBaseBahagianStore(Request $request, Anggota $profil)
    {
        $profil->storeBaseBahagian($request);
    }

    public function rpcFlowShow(Manager $fractal, AnggotaTransformer $anggotaTransformer, Anggota $profil)
    {
        $profil->load(['flow', 'xtraAttr.flowBaseDepartment']);

        $fractal->parseIncludes('flowbahagian,flowanggota');
        $resource = new Item($profil, $anggotaTransformer);
        $transform = $fractal->createData($resource);

        return response()->json($transform->toArray());
    }

    public function rpcFlowUpdate(Request $request, Anggota $profil)
    {
        $profil->updateFlow($request);
    }

    public function rpcPuasaConf(Anggota $profil, Puasa $puasa)
    {
        $senPuasa = $puasa->tahunSemasa()->with(['confs' => function ($query) use ($profil) {
            $query->where('anggota_id', $profil->userid)->orderBy('id');
        }])->get();

        $senPuasaAssocConf = $senPuasa->map(function ($item, $key) use ($profil) {
            $confs = $item->confs;
            unset($item->confs);
            if ($confs->isNotEmpty()) {
                $item->conf = $confs->last();
            } else {
                $item->conf = ["pilihan" => ShiftConf::PUASA];
            }

            return $item;
        });

        return response()->json($senPuasaAssocConf, 200);
    }

    public function rpcPuasaConfStore(Request $request, Anggota $profil)
    {
        $puasa = Puasa::find($request->input('puasa_id'));

        ShiftConf::updateOrCreate(
            [
                'anggota_id' => $profil->userid,
                'puasa_id' => $puasa->id,
                'jenis' => ShiftConf::PUASA
            ],
            [
                'pilihan' => $request->input('pilihan')
            ]
        );

        \Artisan::call('emasa:janafinalatt', [
            '--mula' => $puasa->tkh_mula,
            '--tamat' =>  $puasa->tkh_tamat,
            'users' => $profil->userid,
        ]);
    }

    public function rpcMengandungConf(Anggota $profil)
    {
        $senMengandung = ShiftConf::where('anggota_id', $profil->userid)
            ->where('jenis', ShiftConf::MENGANDUNG)
            ->tahunSemasa()
            ->get();

        return response()->json($senMengandung, 200);
    }

    public function rpcMengandungConfStore(Request $request, Anggota $profil)
    {
        $shiftMengandungConf = ShiftConf::create(
            [
                'anggota_id' => $profil->userid,
                'puasa_id' => $request->input('puasa_id'),
                'jenis' => $request->input('jenis'),
                'pilihan' => $request->input('pilihan'),
                'tkh_mula' => $request->input('tkh_mula'),
                'tkh_tamat' => $request->input('tkh_tamat'),
            ]
        );

        \Artisan::call('emasa:janafinalatt', [
            '--mula' => $request->input('tkh_mula'),
            '--tamat' =>  $request->input('tkh_tamat'),
            'users' => $profil->userid,
        ]);

        return response()->json($shiftMengandungConf, 201);
    }

    public function rpcMengandungConfDelete(Anggota $profil, ShiftConf $shiftConf)
    {
        $tkh_mula = $shiftConf->tkh_mula;
        $tkh_tamat = $shiftConf->tkh_tamat;

        $shiftConf->delete();

        \Artisan::call('emasa:janafinalatt', [
            '--mula' => $tkh_mula,
            '--tamat' =>  $tkh_tamat,
            'users' => $profil->userid,
        ]);
    }
}
