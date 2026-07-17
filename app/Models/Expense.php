<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id', 'amount', 'expense_date', 'description'
    ];

    protected $casts = [
        'expense_date' => 'date',
    ];

    protected static function booted()
    {
        static::addGlobalScope('branch_tenancy', function (Builder $builder) {
            if (Auth::check() && Auth::user()->role !== 'Superadmin') {
                $builder->where('branch_id', Auth::user()->branch_id);
            }
        });
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}