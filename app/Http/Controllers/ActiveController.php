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
                return response(
                    $data = [ 'message' => 'activos no encontrados!'],
                    $status = 200
                );
            }
        } catch (QueryException $e) {
            return response(
                $data = [
                    'message' => "activos no encontrados!",
                    'errorInfo' => $e->errorInfo
                ],
                $status = 403
            );
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
            return response(
                $data = [
                    'message' => "active not created!",
                    'errorInfo' => $e->errorInfo
                ],
                $status = 403
            );
        }

        return response(
            $data = "active created successfully!",
            $status = 201
        );
    }

    public function viewactive(Request $request, $id){
        try {
            $active = Active::with([
                'provider',
                'payment',
            ])->where('id', $id)->get();
        } catch (QueryException $e) {
            return response(
                $data = [
                    'message'=>"activo no encontrado!",
                    'errorInfo'=>$e->errorInfo
                ],
                $status = 404
            );
        }

        return response(
            $data = $active,
            $status = 200
        );
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
            return response(
                $data = [
                    'message'=>"activo no editado!",
                    'errorInfo'=>$e->errorInfo
                ],
                $status = 404
            );
        }

        return response(
            $data = [ "message"=>"activo editado!"],
            $status = 200
        );
    }
}
