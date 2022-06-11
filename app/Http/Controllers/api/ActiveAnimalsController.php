<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController;
use App\Models\ActiveAnimal;
class ActiveAnimalsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = ActiveAnimal::listAll();

        return Response()->json($result);
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $result = ActiveAnimal::addAnimal($request->all());

        return response()->json($result);
    }

    public function show(Request $request, $name)
    {
        $result = ActiveAnimal::getByName($name);
        return response()->json($result);
    }

    public function update(Request $request)
    {
        $result = ActiveAnimal::upAge($request->all());
        return response()->json($result);
    }

    public function deleteAll(Request $request)
    {
        ActiveAnimal::deleteAll();
        $result = [
            'error' => null,
            'data' => null
        ];
        return response()->json($result);
    }

    public function deleteByName(Request $request)
    {
        $result = ActiveAnimal::deleteByName($request->all());
        return response()->json($result);
    }
}
