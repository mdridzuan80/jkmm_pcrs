<?php

namespace App\Http\Controllers;

use App\Utility;
use App\Anggota;
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
}
