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
                return response()->json(
                    $response = [
                        'message' => "activos no encontrados!"
                    ],
                    $status = 200
                );
            }
        } catch (QueryException $e) {
            return response()->json(
                $response = [
                    'message' => "activos no encontrados!",
                    'errorInfo' => $e->errorInfo
                ],
                $status = 403
            );
        }

        return response()->json(
            $data=[$activos],
            $status=200
        );
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
            return response()->json(
                $response = [
                    'message' => "active not created!",
                    'errorInfo' => $e->errorInfo
                ],
                $status = 403
            );
        }

        return response()->json(
            $data="active created successfully!",
            $status=201
        );
    }

    public function viewactive(Request $request, $id){
        try {
            $active = Active::with([
                'provider',
                'payment',
            ])->where('id', $id)->get();
        } catch (QueryException $e) {
            return response()->json(
                $data=[
                    'message'=>"active created successfully!",
                    'errorInfo'=>$e->errorInfo
                ],
                $status=403
            );
        }

        return response()->json(
            $data=$active,
            $status=200
        );
    }
}
