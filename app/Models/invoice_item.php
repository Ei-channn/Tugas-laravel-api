<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_item extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'item_id',
        'jumlah',
        'total_harga',
    ];
}
