<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    public function index()
    {
        return view('stores.index');
    }

    public function datatables(Request $request)
    {
        return Store::getDataTables($request);
    }
}
