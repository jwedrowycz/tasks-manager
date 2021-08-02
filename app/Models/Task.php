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

    public function getStartAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getExpectedEndAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
    
    protected function scopeActive()
    {
        return $this->where('is_active', true);
    }    

    protected function scopePublic()
    {
        return $this->where('is_private', false);
    }

    protected function scopePrivate()
    {
        return $this->where('is_private', true);
    }

    protected function scopeWithFilters($query)
    {
        return $query;
    }
}
