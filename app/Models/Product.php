<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    const ARTICLE_DEFAULT_COVER = '/image/default-image.svg';
    const ARTICLE_SIZE_150 = '150';
    const ARTICLE_SIZE_300 = '300';
    const ARTICLE_SIZE_750 = '750';

    protected $fillable = [
        'code',
        'name',
        'slug',
        'details',
        'description',
        'like',
        'buy',
        'price_from',
        'price_to',
        'image',
        'user_id'
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id');
    }

    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class, 'product_id');
    }

    public function formatUserName()
    {
        $user = $this->user;

        return !is_null($user) ? $user['username'] : '';
    }

    public function formatImage($size)
    {
        $path = route('scontent.show', base64_encode(self::ARTICLE_DEFAULT_COVER));
        if (!is_null($this->image)) {
            $imageDecoded = base64_decode($this->image);
            switch ($size) {
                case self::ARTICLE_SIZE_150:
                    $path = route('scontent.show', base64_encode('/image/150x200/' . $imageDecoded));
                    break;
                case self::ARTICLE_SIZE_300:
                    $path = route('scontent.show', base64_encode('/image/300x400/' . $imageDecoded));
                    break;
                case self::ARTICLE_SIZE_750:
                    $path = route('scontent.show', base64_encode('/image/750x1000/' . $imageDecoded));
                    break;
                default:
                    break;
            }
        }

        return $path;
    }

    public function categoryName()
    {
        $categories = [];
        foreach ($this->categories as $category) {
            $categoryO = new \stdClass();
            $categoryO->id = $category->id;
            $categoryO->value = $category->name;
            $categories[] = $categoryO;
        }
        return $categories;
    }
}
