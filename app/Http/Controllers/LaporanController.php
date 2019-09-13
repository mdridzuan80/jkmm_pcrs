<?php

namespace App\Http\Controllers;

use App\Department;
use LaporanRepository;
use League\Fractal\Manager;
use Illuminate\Support\Arr;
use App\Base\BaseController;
use League\Fractal\Resource\Collection;
use App\Http\Requests\LaporanHarianRequest;
use App\Transformers\LaporanHarianTransformer;

class LaporanController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->renderView('laporan.index');
    }

    
    public function harian()
    {
        return $this->renderView('laporan.harian');
    }

    public function rpcHarian(LaporanHarianRequest $request, Manager $fractal, LaporanHarianTransformer $LaporanHariantransformer)
    {
        $bahagian = Department::find($request->input('txtDepartmentId'));
        $rekod = LaporanRepository::laporanHarian($request->input('txtDepartmentId'), $request->input('txtTarikh'));

        $resource = new Collection($rekod, $LaporanHariantransformer);
        $transform = $fractal->createData($resource);

        return response()->json(Arr::add($transform->toArray(), 'bahagian', $bahagian->deptname));
    }
}
