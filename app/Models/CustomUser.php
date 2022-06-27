<?php

namespace App\Models;

use App\Models\UserDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'password',
        'email'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user_details() {
        return $this->hasOne(UserDetails::class, 'user_id')->select(['id', 'address']);
    }
}
