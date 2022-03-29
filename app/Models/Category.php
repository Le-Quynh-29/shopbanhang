<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories";

    const ARTICLE_DEFAULT_COVER = '/image/default-image.svg';
    const ARTICLE_SIZE_150 = '150';
    const ARTICLE_SIZE_300 = '300';
    const ARTICLE_SIZE_750 = '750';

    protected $fillable =  [
        'name',
        'slug',
        'image',
        'user_id'
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category', 'category_id', 'product_id');
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
}
