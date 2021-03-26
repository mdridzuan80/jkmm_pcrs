<?php

namespace App\Http\Controllers;

use App\Anggota;
use Carbon\Carbon;
use App\Department;
use League\Fractal\Manager;
use App\Transformers\Event;
use Illuminate\Support\Arr;
use App\Base\BaseController;
use League\Fractal\Resource\Collection;
use App\Repositories\LaporanRepository;
use App\Http\Requests\LaporanHarianRequest;
use App\Http\Requests\LaporanBulananRequest;
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

    public function bulanan()
    {
        return $this->renderView('laporan.bulanan');
    }

    public function rpcBulanan(LaporanBulananRequest $request, Manager $fractal, Event $event)
    {
        $records = [];
        $mula = Carbon::parse($request->input('txtTarikh'));
        $bulanSebelum = (clone $mula)->subMonth();
        $tamat = (clone $mula)->addMonth();
        $officers = Anggota::whereIn('userid', $request->input('comPegawai'))->get();

        foreach ($officers as $officer) {

            $events = (new LaporanRepository)->laporanBulanan($officer, $mula, $tamat);
            $resource = new Collection($events, $event);
            $transform = $fractal->createData($resource);

            array_push($records, [
                'userid' => $officer->userid,
                'name' => $officer->xtraAttr->nama,
                'deptname' => $officer->xtraAttr->department->deptname,
                'bulan' => $mula->englishMonth . "-" . $mula->year,
                'warna' => $officer->xtraAttr->warnaKadByBulan($bulanSebelum->month, $bulanSebelum->year),
                'events' => $transform->toArray(),
            ]);
        }

        return response()->json($records);
    }
}
