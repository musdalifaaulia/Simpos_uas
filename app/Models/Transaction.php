<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number', 'branch_id', 'user_id', 'customer_id', 
        'total_amount', 'payment_method', 'status'
    ];

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}