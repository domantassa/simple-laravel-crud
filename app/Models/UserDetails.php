<?php

namespace App\Models;

use App\Models\CustomUser;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'address',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(CustomUser::class);
    }
}
