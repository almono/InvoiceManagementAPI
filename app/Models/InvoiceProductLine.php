<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Invoice;

class InvoiceProductLine extends Model
{
    protected $table    = 'invoice_product_lines';
    protected $fillable = ['invoice_id', 'name', 'price', 'quantity', 'created_at', 'updated_at'];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}