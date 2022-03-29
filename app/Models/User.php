<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";

    public const ACTIVE = 1;
    public const INACTIVE = 0;
    public const ADMIN = 1;
    public const CTV = 2;
    public const USER = 3;
    public const MALE = 1;
    public const FEMALE = 2;
    public const ROLES = [
        '3' => 'Người dùng',
        '2' => 'Cộng tác viên',
        '1' => 'Admin'];
    public const SEXES =  [
        '1' => 'Nam',
        '2' => 'Nữ'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'username',
        'gender',
        'birthday',
        'numer_phone',
        'email',
        'password',
        'active',
        'role',
    ];

    public $timestamps = true;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function formatRole()
    {
        $role = $this->role;
        switch ($role) {
            case self::ADMIN:
                return 'Admin';
            case self::CTV:
                return 'Cộng tác viên';
            case self::USER:
                return 'Người dùng';
            default:
                return '';
        }
    }

    public function formatGender()
    {
        $gender = $this->gender;
        switch ($gender) {
            case self::MALE:
                return 'Nam';
            case self::FEMALE:
                return 'Nữ';
            default:
                return 'Giới tính không xác định';
        }
    }

    public function formatActive()
    {
        $active = $this->active;
        switch ($active) {
            case self::ACTIVE:
                return 'Đang hoạt động';
            case self::INACTIVE:
                return 'Vô hiệu hóa';
            default:
                return '';
        }
    }

    public function isAdmin() {
        $role = $this->role;
        if($role == self::ADMIN) {
            return true;
        }

        return false;
    }
}
