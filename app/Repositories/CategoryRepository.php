<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Support\AbstractRepository;
use App\Traits\LogTrait;
use Illuminate\Container\Container;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

Paginator::useBootstrap();

class CategoryRepository extends AbstractRepository
{
    use LogTrait;
    public function model()
    {
        return 'App\Models\Category';
    }

    public function __construct(Container $app)
    {
        parent::__construct($app);
    }

    /**
     * Check validate unique name
     *
     * @param mixed $id
     * @param mixed $name
     * @return void
     */
    public function validateUniqueName($id, $name)
    {
        $data = Category::where('name', $name);

        if (!is_null($id)) {
            $data = $data->where('id', '<>', $id);
        }
        $data = $data->get();

        if (sizeof($data) == 0) {
            return true;
        }
        return false;
    }

    public function deleteProduct($categoryId, $productId)
    {
        DB::table('product_category')->where('category_id', $categoryId)
            ->where('product_id', $productId)
            ->delete();
        $event = "Xóa sản phẩm khỏi danh mục";
        $data = [
            'category' => $categoryId,
            'product' => $productId
        ];
        $this->createLog($event, $data);
        toastr()->success('Xóa sản phẩm khỏi danh mục thành công');
    }

    public function deleteRelation($categoryId)
    {
        DB::table('product_category')->where('category_id', $categoryId)
            ->delete();
    }

    public function autocomplete($term)
    {
        $categories = Category::where('name', 'LIKE', '%' . $term . '%');

        $categories = $categories->limit(20)->orderBy('id', 'desc')->get();

        $arr = [];
        foreach ($categories as $category) {
            $categoryO = new \stdClass();
            $categoryO->id = $category->id;
            $categoryO->value = $category->name;
            $arr[] = $categoryO;
        }
        return $arr;
    }
}
