<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController;
use App\Models\Animal;

class AnimalsController extends BaseController
{
    public function index(Request $request)
    {
        $response = null;
        if(isset($request['kind'])){
            $response = $this->show($request, $request['kind']);
        }
        else {
            $result = Animal::getAllKinds();
            $response = Response()->json($result);
            Log::channel('api_animals')->debug('Get list kind: ', $result);
        }
        return $response;
    }


    public function show(Request $request, $kind)
    {
        $result = Animal::getKind($kind);
        return response()->json($result);
    }

    public function delete(Request $request, $kind)
    {
        $result = Animal::deleteByKind($kind);
        return Response()->json($result);
    }

    public function deleteAll(Request $request)
    {
        $result = Animal::deleteAll();
        return Response()->json($result);
    }
}
