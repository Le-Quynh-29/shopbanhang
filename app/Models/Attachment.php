<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $table = "attachments";

    public const ENTITY_TYPE_CMT = 'CMT';
    public const ENTITY_TYPE_SP = 'SP';
    const COVER_RESIZES = [
        [
            'width' => 150,
            'height' => 200,
            'path' => 'image/150x200/'
        ],
        [
            'width' => 300,
            'height' => 400,
            'path' => 'image/300x400/'
        ],
        [
            'width' => 750,
            'height' => 1000,
            'path' => 'image/750x1000/'
        ]
    ];

    protected $fillable = [
        'name',
        'ext',
        'size',
        'path',
        'pos',
        'entity_type',
        'entity_id',
        'user_id'
    ];

    public $timestamps = true;
}
