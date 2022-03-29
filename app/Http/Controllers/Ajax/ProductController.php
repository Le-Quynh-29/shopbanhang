<?php
namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Ajax\AjaxController;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends AjaxController
{
    protected $productRepo;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function validateUniqueName(Request $request)
    {
        $name = $request->name;
        $id = $request->id;
        $data = $this->productRepo->validateUniqueName($name, $id);
        return $this->responseSuccess($data);
    }

    public function validateUniqueCode(Request $request)
    {
        $code = $request->code;
        $id = $request->id;
        $data = $this->productRepo->validateUniqueCode($code, $id);
        return $this->responseSuccess($data);
    }
}
