<?php

namespace App\Http\Controllers;

use App\Bdrsetting;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Base\BaseController;
use League\Fractal\Resource\Item;
use App\Transformers\BdrTransformer;
use League\Fractal\Resource\Collection;

class BdrController extends BaseController
{
    public function index(Bdrsetting $bdr, Manager $fractal)
    {
        $resource = new Collection($bdr->byTahun(), new BdrTransformer);
        $transform = $fractal->createData($resource);

        return response()->json($transform->toArray());
    }

    public function store(Request $request, Bdrsetting $bdr, Manager $fractal)
    {
        $bdr->bahagian_id = $request->input("bahagian_id");
        $bdr->tkhmula = $request->input("tkhMula");
        $bdr->tkhtamat = $request->input("tkhTamat");
        $bdr->save();

        $resource = new Item($bdr, new BdrTransformer);
        $transform = $fractal->createData($resource);

        return response()->json($transform->toArray(), 201);
    }

    public function destroy(Bdrsetting $bdr)
    {
        $bdr->delete();
        return response('Success', 200);
    }
}
