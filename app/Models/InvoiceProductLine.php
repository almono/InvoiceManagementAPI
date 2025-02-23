<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class InvoiceProductLine extends Model
{
    use HasUuids;

    protected $table        = 'invoice_product_lines';
    protected $primaryKey   = 'id';
    protected $keyType      = 'string';
    //public $incrementing    = false;
    protected $fillable     = ['invoice_id', 'name', 'price', 'quantity', 'created_at', 'updated_at'];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
}