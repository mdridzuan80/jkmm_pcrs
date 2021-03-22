<?php

namespace App\Http\Controllers;

use Auth;
use App\Cuti;
use App\Acara;
use App\Anggota;
use App\Kehadiran;
use Carbon\Carbon;
use League\Fractal\Manager;
use App\Transformers\Event;
use App\Base\BaseController;
use Illuminate\Http\Request;
use App\Abstraction\Eventable;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use App\Repositories\LaporanRepository;
use App\Http\Requests\StoreAcaraRequest;

class KalendarController extends BaseController
{
    private $_eventable;
    private $_viewAcara;

    public function __construct()
    {
        $this->_eventable = [
            'cuti',
            'kehadiran',
            'finalKehadiran',
            'acara',
        ];

        parent::__construct();
    }

    public function index()
    {
        if (Auth::user()->email == 'admin@internal') {
            return $this->renderView('dashboard.admin.index');
        }

        return $this->renderView('dashboard.pengguna.index');
    }

    public function rpcEventAnggotaIndex(Anggota $profil, Request $request, Manager $fractal, Event $event)
    {
        $events = (new LaporanRepository)->laporanBulanan($profil, $request->input('start'), $request->input('end'));
        $resource = new Collection($events, $event);
        $transform = $fractal->createData($resource);

        return response()->json($transform->toArray());
    }

    public function rpcEventAnggotaCreate()
    {
        return view('dashboard.acara.create');
    }

    public function rpcEventAnggotaStore(Anggota $profil, StoreAcaraRequest $request, Manager $fractal, Event $event)
    {
        $acara = Acara::storeAcara($profil, $request);
        $manager = $fractal->createData(new Item($acara, $event));

        if ($acara && $acara->eventableItem()) {
            return response()->json($manager->toArray());
        }

        return response()->json($acara, 409);
    }

    public function rpcEventAnggotaShow(Anggota $profil, $acaraId, $jenisSumber)
    {
        if ($jenisSumber !== Eventable::CURRENTATT) {
            $event = $this->_eventable[$jenisSumber]::events()->findOrFail($acaraId);
        }

        if ($jenisSumber === Eventable::CURRENTATT) {
            $jenisSumber = Eventable::FINALATT;
            $event = optional(Kehadiran::events()->whereBetween('CHECKTIME', [today()->addHours(4), today()->addHours(13)])->first())->toArray();
        }

        return $this->viewAcara($jenisSumber, $event);
    }

    public function rpcEventAnggotaShow2(Anggota $profil, $tarikh)
    {
        $events = collect([]);
        $tarikh = Carbon::parse($tarikh);

        foreach ($this->_eventable as $eventable) {
            $events = $events->merge($profil->getAcaraTerlibat($eventable, $tarikh));
        }

        return view('dashboard.acara.show.acara', compact('events', 'tarikh'));
    }

    private function viewAcara($jenisSumber, $event)
    {
        $this->_viewAcara = [
            Eventable::FINALATT => 'dashboard.acara.show.final',
            Eventable::CUTI => 'dashboard.acara.show.cuti',
            Eventable::ACARA => 'dashboard.acara.show.acara',
        ];

        return view($this->_viewAcara[$jenisSumber], compact('event'));
    }
}
