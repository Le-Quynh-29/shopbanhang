<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

Paginator::useBootstrap();

class ProductController extends Controller
{
    protected $productRepo;
    protected $categoryRepo;

    public function __construct(
        ProductRepository $productRepo,
        CategoryRepository $categoryRepo
    )
    {
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Product::class);
        $products = $this->productRepo->all($request, false);
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize("create", Product::class);
        $category = old('category');
        if (!is_null($category)) {
            $categoryTagify = $category;
        } else {
            $categoryTagify = json_encode([]);
        }
        return view("admin.product.create", compact('categoryTagify'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $product = $this->productRepo->createWithLog($data);
        return redirect()->route('product.edit', [$product->id, 'tab' => 1]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $product = $this->productRepo->find($id);
        if (is_null($product)) {
            abort(404);
        }
        $this->authorize('update', $product);
        $tab = $request->get('tab') ? $request->get('tab') : 1;
        $categoryTagify = json_encode($product->categoryName());
        $productDetails = count($product->productDetails) !== 0 ? json_encode($product->productDetails->toArray()) : "[]";
        return view('admin.product.edit', compact('product', 'tab', 'categoryTagify', 'productDetails'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $this->productRepo->updateWithLog($id, $data);
        return redirect()->route('product.edit', [$id, 'tab' => 1]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDetal(Request $request, $id)
    {
        $data = $request->all();
        $this->productRepo->updateDetail($data, $id);
        return redirect()->back();
    }
}
