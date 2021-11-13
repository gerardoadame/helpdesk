<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{

    function index()
    {
        return Area::all();
    }

    function store(Request $request)
    {
        return Area::create(['name' => $request->get('name')]);
    }


    function show(int $id)
    {
        return Area::findOrFail($id);
    }


    function update(Request $request, int $id)
    {
        $area = Area::findOrFail($id);
        $area->name = $request->get('name');
        $area->save();

        return $area;
    }


    function destroy(int $id)
    {
        //
    }
}
