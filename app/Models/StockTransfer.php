<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    /** @use HasFactory<\Database\Factories\StockTransferFactory> */
    use HasFactory;
    protected $fillable = ['reference_number', 'from_branch_id', 'to_branch_id', 'product_id', 'quantity', 'status'];
}
