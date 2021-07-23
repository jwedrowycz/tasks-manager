<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start',
        'expected_end',
        'end',
        'registered_by',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
