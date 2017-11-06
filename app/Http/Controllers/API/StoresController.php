<?php

namespace App\Http\Controllers\API;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoresController extends Controller
{
    public function index(Request $request)
    {
        try {
            $filter = null;
            $keyword = '';
            $type = 0;
            if ($request->has('filter')) {
                $filter = $request->filter;
            }
            if ($request->has('search')) {
                $keyword = $request->search;
            }
            if ($request->has('type')) {
                $type = config('system.stores.type')[$request->type];
            }
            dd($type);
            $stores = Store::getAllStore($type, $filter, $keyword);
        }
        catch (\Exception $e) {
            return Response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
        return Response()->json(['status' => true, 'data' => $stores]);
    }

    public function show($id)
    {
        try {
            $store = Store::getDetail($id);
        }
        catch (\Exception $e) {
            return Response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
        return Response()->json(['status' => true, 'data' => $store]);
    }
}
