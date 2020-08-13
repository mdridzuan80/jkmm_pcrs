<?php

namespace App\Http\Controllers;

use App\Puasa;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use App\Transformers\PuasaTransformer;

class PuasaController extends Controller
{
    public function index(Puasa $puasa, Manager $fractal)
    {
        $resource = new Collection($puasa->byTahun(), new PuasaTransformer);
        $transform = $fractal->createData($resource);

        return response()->json($transform->toArray());
    }

    public function store(Request $request, Puasa $puasa, Manager $fractal)
    {
        $puasa->tkhmula = $request->input("tkhMula");
        $puasa->tkhtamat = $request->input("tkhTamat");
        $puasa->save();

        $resource = new Item($puasa, new PuasaTransformer);
        $transform = $fractal->createData($resource);

        return response()->json($transform->toArray(), 201);
    }

    public function destroy(Puasa $puasa)
    {
        $puasa->delete();
        return response('Success', 200);
    }
}
