<?php

namespace App\Http\Controllers;

use App\Cuti;
use App\Department;
use League\Fractal\Manager;
use App\Base\BaseController;
use Illuminate\Http\Request;
use App\Transformers\FlowBahagianTransformer;
use League\Fractal\Resource\Item as FractalItem;

class KonfigurasiController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->renderView('konfigurasi.index');
    }

    public function rpcFlowBahagianShow(Department $department, Manager $fractal, FlowBahagianTransformer $flowBahagianTransformer)
    {
        $resource = new FractalItem($department->flow, $flowBahagianTransformer);
        $transform = $fractal->createData($resource);

        return response()->json($transform->toArray());
    }

    public function rpcFlowBahagianUpdate(Department $department, Request $request)
    {
        $department->updateFlow($request);
    }

    public function rcpGridCuti(Request $request)
    {
        $perPage = 10;

        $years = Cuti::years();
        $year = $request->input('tahun', now()->year);
        $cuti = Cuti::whereYear('tarikh', $year)->paginate($perPage);

        return view('cuti.index', compact('cuti', 'years', 'year'));
    }

    public function rpcCutiAdd()
    {
        return view('cuti.add');
    }

    public function rpcCutiStore(Request $request)
    {
        $cuti = Cuti::firstOrNew(['tarikh' => $request->input('txtTarikhCuti')]);

        $cuti->tarikh = $request->input('txtTarikhCuti');
        $cuti->perihal = $request->input('txtPerihal');
        $cuti->save();
    }

    public function rcpCutiDestroy(Request $request)
    {
        $cuti = Cuti::find($request->input('cutiId'));
        $cuti->delete();
    }
}
