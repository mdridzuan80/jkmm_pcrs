<?php

namespace App\Base;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    private $navi;

    public function __construct()
    {
        //$routeArray = Route::getCurrentRoute()->getAction();
        list($controller, $action) = $this->getControllerAction();

        $this->navi['activeTree'] = strtolower($controller);
        $this->navi['activeMenu'] = strtolower($controller . "_" . $action);
    }

    protected function getControllerAction()
    {
        $routeArray = app('request')->route()->getAction();
        $controllerAction = class_basename($routeArray['controller']);

        return explode('@', $controllerAction);
    }

    protected function renderView($yield, $data = [])
    {
        $collection = collect($data);
        $collection = $collection->merge($this->navi);

        return view($yield, compact('collection'));
    }
}
