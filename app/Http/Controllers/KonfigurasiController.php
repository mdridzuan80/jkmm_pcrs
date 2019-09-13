<?php

namespace App\Http\Controllers;

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
}
