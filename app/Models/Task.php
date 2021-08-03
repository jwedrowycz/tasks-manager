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

    protected function getStartAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    protected function getExpectedEndAttribute($value)
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
        return $this->where('user_id', auth()->id());
    }

    protected function scopeWithFilters($query)
    {
        return $query->when(count(request()->query()) > 0, function ($query) {
            $query->when(request()->query('all_tasks') == "true", function ($query) {
                $query->where('user_id', '!=', auth()->id());
            });
            $query->when(request()->input('completed') == "true", function ($query) {
                $query->whereNotNull('end');
            });
        });

        // $query->when(request()->input('is_private') == false, function ($q) {
        //     return $q->where('user_id');
        // });
        // $query->when(request()->input('completed') == true, function ($q) {
        //     return $q->whereNotNull('end');
        // });
        // $query->when(request()->input('completed') == false, function ($q) {
        //     return $q->where('end', true);
        // });
    }
}
