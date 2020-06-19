<?php

namespace App\Http\Controllers;

use App\Puasa;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use App\Transformers\PuasaTransformer;
use League\Fractal\Resource\Collection;

class PuasaController extends Controller
{
    public function index(Puasa $puasa)
    {
        $fractal = new Manager;
        $resource = new Collection($puasa->byTahun(), new PuasaTransformer);
        $transform = $fractal->createData($resource);

        return response()->json($transform->toArray());
    }

    public function store(Request $request)
    {
        $addPuasa = new Puasa;
        $addPuasa->tkhmula = $request->input("tkhMula");
        $addPuasa->tkhtamat = $request->input("tkhTamat");
        $addPuasa->save();

        $fractal = new Manager;
        $resource = new Item($addPuasa, new PuasaTransformer);
        $transform = $fractal->createData($resource);

        return response()->json($transform->toArray(), 201);
    }

    public function destroy(Puasa $puasa)
    {
        $puasa->delete();
        return response('Success', 200);
    }
}
