<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Active;
use App\Models\Supply;
use App\Models\Provider;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function datos()
    {
        // $datos = Supply::findOrFail(1);
        // $datos->active;
        // dd($datos->active[0]);
        $datos = Supply::findOrFail(1);
        $datos->active;
        dd($datos);
    }
}
