<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Ajax\AjaxController;;
use App\Repositories\CategoryRepository;
use App\Traits\LogTrait;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;

Paginator::useBootstrap();

class CategoryController extends AjaxController
{
    use LogTrait;

    protected $categoryRepo;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * Check validate unique name
     *
     * @param mixed $request
     * @return void
     */
    public function validateUniqueName(Request $request)
    {
        $id = $request->get('id');
        $name = $request->get('name');
        $data = $this->categoryRepo->validateUniqueName($id, $name);
        return $this->responseSuccess($data);
    }

    /**
     * Category autocomplete
     *
     * @return void
     */
    public function autocomplete(Request $request)
    {
        $term = $request->get('term');
        $categories = $this->categoryRepo->autocomplete($term);
        return $this->responseSuccess($categories);
    }
}
