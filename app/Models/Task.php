<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;
use DateTimeInterface;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start',
        'expected_end',
        'end',
        'user_id',
        'is_active',
        'is_private'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
}
