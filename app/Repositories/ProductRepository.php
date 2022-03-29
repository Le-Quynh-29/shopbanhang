<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Repositories\Support\AbstractRepository;
use App\Traits\LogTrait;
use App\Traits\StorageTrait;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

Paginator::useBootstrap();

class ProductRepository extends AbstractRepository
{
    use LogTrait, StorageTrait;

    public function model()
    {
        return 'App\Models\Product';
    }

    public function __construct(Container $app)
    {
        parent::__construct($app);
    }

    public function validateUniqueName($name, $id)
    {
        $data = Product::where('name', $name);

        if (!is_null($id)) {
            $data = $data->where('id', '<>', $id);
        }

        $data = $data->get();

        if (sizeof($data) == 0) {
            return true;
        }
        return false;
    }

    public function validateUniqueCode($code, $id)
    {
        $data = Product::where('code', $code);

        if (!is_null($id)) {
            $data = $data->where('id', '<>', $id);
        }

        $data = $data->get();

        if (sizeof($data) == 0) {
            return true;
        }

        return false;
    }

    public function createWithLog(array $data)
    {
        $image = null;
        if (isset($data['image'])) {
            $image = $this->storageUploadImage($data['image']);
        }
        $data['slug'] = \ShopHelper::genPath($data['name']);
        $product = Product::create([
            'code' => $data['code'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => Str::replace('&nbsp;', ' ', $data['description']),
            'image' => $image,
            'user_id' => Auth::id()
        ]);
        $categories = isset($data['category']) ? json_decode($data['category']) : null;
        $this->createProductCategory($categories, $product);
        // Create log when create
        $event = 'Thêm mới sản phẩm';
        $data = [
            'product' => $product,
            'product_category' => $categories
        ];
        $this->createLog($event, $data);
        toastr()->success('Thêm mới sản phẩm thành công');
        return $product;
    }

    public function updateWithLog($id, $data)
    {
        $product = Product::findOrFail($id);
        $oldProduct = $product->getOriginal();
        $image = $product->image;
        if (isset($data['image'])) {
            $image = $this->storageUploadImage($data['image']);
        }

        $data['slug'] = \ShopHelper::genPath($data['name']);
        Product::where('id', $id)->update([
            'code' => $data['code'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => Str::replace('&nbsp;', ' ', $data['description']),
            'image' => $image,
        ]);
        $newProduct = Product::where('id', $id)->first();
        $categories = isset($data['category']) ? json_decode($data['category']) : null;
        $this->createProductCategory($categories, $newProduct);
        // Create log when update
        $event = 'Cập nhật sản phẩm';
        $data = [
            'old' => $oldProduct,
            'new' => $newProduct
        ];
        $this->createLog($event, $data);
        toastr()->success('Cập nhật sản phẩm thành công');
    }

    public function createProductCategory($categories, $product)
    {
        if (!is_null($categories)) {
            // Detach all table relation
            $this->detachAll($product->id);
            foreach ($categories as $id) {
                $category = Category::where('id', $id->id)->first();
                if (!is_null($category)) {
                    DB::table('product_category')->insert([
                        'category_id' => $category->id,
                        'product_id' => $product->id
                    ]);
                }
            }
        }
    }

    public function detachAll($id)
    {
        DB::table('product_category')
            ->where('product_id', $id)
            ->delete();
    }

    public function deleteProductDetail($id)
    {
        DB::table('product_details')
            ->where('product_id', $id)
            ->delete();
    }

    public function updateDetail($data, $id)
    {
        $productDetails = json_decode($data['product_detail']);
        $this->deleteProductDetail($id);
        foreach ($productDetails as $productDetail) {
            DB::table('product_details')->insert([
                'product_id' => $id,
                'color' => $productDetail->color,
                'size' => $productDetail->size,
                'price' => (float)str_replace(',','', $productDetail->price),
                'quantity' => $productDetail->quantity,
                'user_id' => Auth::id()
            ]);
        }

        $details = isset($data['details']) && count(json_decode($data['details'])) !== 0? $data['details'] : null;
        Product::where('id', $id)->update([
           'details' => $details
        ]);

        $event = "Cập nhật các thông tin khác của sản phẩm";
        $data = [
            'product_id' => $id,
            'product_detail' => $data['product_detail'],
            'details' => $data['details']
        ];

        $this->createLog($event, $data);
        toastr('Cập nhật các thông tin khác của sản phẩm thành công');
    }
}
