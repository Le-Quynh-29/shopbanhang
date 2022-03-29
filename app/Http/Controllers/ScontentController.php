<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Repositories\ScontentRepository;

class ScontentController
{
    protected $scontentRepo;

    public function __construct(ScontentRepository $scontentRepo)
    {
        $this->scontentRepo = $scontentRepo;
    }

    /**
     * Show storage file
     * @param string $path
     * @param Request $request
     * @return response
     */
    public function show($path)
    {
        if ($path == '') {
            abort(404);
        }
        return $this->scontentRepo->responseFile($path);
    }
}
