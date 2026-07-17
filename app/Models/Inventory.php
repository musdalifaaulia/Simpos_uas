<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Inventory extends Model
{
    use HasFactory;
    
    protected $fillable = ['branch_id', 'product_id', 'stock_quantity', 'min_stock_level'];

    protected static function booted()
    {
        // Global scope for branch-based row-level tenancy
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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}