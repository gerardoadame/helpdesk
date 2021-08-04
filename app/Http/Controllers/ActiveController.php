<?php

namespace App\Http\Controllers;

use App\Models\{Active};
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ActiveController extends Controller
{
    public function list(Request $request){
        try {
            // $activos=Active::all();
            $activos=Active::with([
                'provider',
                'payment'
            ])->get();
            #en caso de que no hya activos registrados se regresa el mensaje
            if(count($activos)==0){
                return response([ 'message' => 'activos no encontrados!']);
            }
        } catch (QueryException $e) {
            return response([
                'message' => "activos no encontrados!",
                'errorInfo' => $e->errorInfo
            ]);
        }

        return response($activos);
    }

    public function create(Request $request){
        try {
            $request->validate([
                'equipment'=>'required',
                'model'=>'required',
                'features'=>'required',
                'purchase'=>'required',
                'warranty'=>'required',
                'serie'=>'required',
                'provider'=>'required',
                'payment'=>'required'
            ]);
            $active=Active::create([
                'equipment'=>$request->get('equipment'),
                'model'=>$request->get('model'),
                'features'=>$request->get('features'),
                'purchase'=>$request->get('purchase'),
                'warranty'=>$request->get('warranty'),
                'serie'=>$request->get('serie'),
                'provider_id'=>$request->get('provider'),
                'payment_id'=>$request->get('payment')
            ]);

        } catch (QueryException $e) {
            return response([
                'message' => "active not created!",
                'errorInfo' => $e->errorInfo
            ], 403);
        }

        return response("active created successfully!", 201);
    }

    public function viewactive(Request $request, $id){
        try {
            $active = Active::with([
                'provider',
                'payment',
            ])->where('id', $id)->get();
        } catch (QueryException $e) {
            return response([
                'message'=>"activo no encontrado!",
                'errorInfo'=>$e->errorInfo
            ], 404);
        }

        return response($active);
    }

    public function edit(Request $request, $id){
        try {
            $active=Active::findOrFail($id);
            $active->update([
                'equipment'=> request('equipment'),
                'model'=>request('model'),
                'features'=>request('features'),
                'purchase'=>request('purchase'),
                'warranty'=>request('warranty'),
                'serie'=>request('serie'),
                'stock'=>request('stock'),
                'provider'=>request('provider_id'),
                'payment'=>request('payment_id')
            ]);

        } catch (QueryException $e) {
            return response([
                'message'=>"activo no editado!",
                'errorInfo'=>$e->errorInfo
            ], 404);
        }

        return response([
            "message"=>"activo editado!"
        ]);
    }
}
