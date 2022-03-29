<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Redirect after delete.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param   string  $route
     * @param   object  $repo
     * @return \Illuminate\Http\Response
     */
    public function redirectAfterDelete($repo, $request, $route)
    {
        $tmpRepo =  $repo->all($request, false);
        $page = $tmpRepo->lastPage();
        $oldPage = $page + 1;
        if (url()->previous() == route($route, ['page' => $oldPage])) {
            return redirect()->route($route, ['page' => $page]);
        } else {
            return redirect()->back();
        }
    }
}
