<?php

namespace Modules\Invoices\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Modules\Invoices\Models\InvoiceProductLine;

class Invoice extends Model
{
    protected $table    = 'invoices';
    protected $fillable = ['customer_name', 'customer_email', 'status', 'created_at', 'updated_at'];

    public function comments(): HasMany
    {
        return $this->hasMany(InvoiceProductLine::class);
    }
}