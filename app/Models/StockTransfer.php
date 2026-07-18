<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class StockTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number', 'product_id', 'from_branch_id', 'to_branch_id', 'user_id',
        'quantity', 'transfer_date', 'status', 'notes'
    ];

    protected $casts = [
        'transfer_date' => 'date',
    ];

    protected static function booted()
    {
        // Global scope: user can see transfers involving their branch (in or out)
        static::addGlobalScope('branch_tenancy', function (Builder $builder) {
            if (Auth::check() && Auth::user()->role !== 'Superadmin') {
                $branchId = Auth::user()->branch_id;
                $builder->where(function ($query) use ($branchId) {
                    $query->where('from_branch_id', $branchId)
                          ->orWhere('to_branch_id', $branchId);
                });
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function fromBranch()
    {
        return $this->belongsTo(Branch::class, 'from_branch_id');
    }

    public function toBranch()
    {
        return $this->belongsTo(Branch::class, 'to_branch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}