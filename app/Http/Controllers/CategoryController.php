<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Traits\LogTrait;
use App\Traits\StorageTrait;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

Paginator::useBootstrap();

class CategoryController extends Controller
{
    use LogTrait, StorageTrait;

    protected $categoryRepo;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize("viewAny", Category::class);
        $categories = $this->categoryRepo->all($request, false);
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['image'] = $this->storageUploadImage($request->image);
        $data['slug'] = \ShopHelper::genPath($request->get('name'));
        $data['user_id'] = Auth::id();
        $category = $this->categoryRepo->create($data);
        // Create log when create
        $event = 'Thêm mới danh mục';
        $this->createLog($event, $category);
        toastr()->success('Thêm mới danh mục thành công');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->categoryRepo->find($id);
        if (is_null($category)) {
            abort(404);
        }
        $this->authorize('view', $category);

        return view("admin/category/show", compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $category = $this->categoryRepo->find($id);
        if (is_null($category)) {
            abort(404);
        }
        $this->authorize('delete', $category);
        $this->categoryRepo->deleteRelation($id);
        // Delete category
        $this->categoryRepo->delete($id);
        $event = "Xóa danh mục";
        $this->createLog($event, $category);
        toastr()->success('Xóa danh mục thành công.');
        return $this->redirectAfterDelete($this->categoryRepo, $request, 'category.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateWithLog(Request $request)
    {
        $id = $request->get('id');
        $category = Category::findOrFail($id);
        $oldCategory = $category->getOriginal();
        $data = $request->except(['_token', '_method', '_url']);
        if (isset($request->image)) {
            $data['image'] = $this->storageUploadImage($request->image);
        }
        $data['slug'] = \ShopHelper::genPath($request->get('name'));
        $this->categoryRepo->update($data, $id);
        $newCategory = Category::where('id', $id)->first();
        // Create log when create
        $event = 'Cập nhật danh mục';
        $data = [
            'old' => $oldCategory,
            'new' => $newCategory
        ];
        $this->createLog($event, $data);
        toastr()->success('Cập nhật danh mục thành công');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
//    public function showDeleteProduct(Request $request)
//    {
//        $categoryId = $request->get('category_id');
//        $category = Category::findOrFail($categoryId);
//        $productId = explode($request->)
//
//        return view("admin/category/show", compact('category'));
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteProduct(Request $request)
    {
        $categoryId = $request->get('category_id');
        $productId = $request->get('product_id');
        $this->categoryRepo->deleteProduct($categoryId, $productId);
        return redirect()->back();
    }
}
