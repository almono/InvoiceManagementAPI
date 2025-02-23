<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

use App\Models\InvoiceProductLine;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Invoice extends Model
{
    use HasUuids;

    protected $table        = 'invoices';
    protected $primaryKey   = 'id';
    protected $keyType      = 'string';
    //public $incrementing    = false;
    protected $fillable     = ['customer_name', 'customer_email', 'status', 'created_at', 'updated_at'];

    public function productLine(): HasMany
    {
        return $this->hasMany(InvoiceProductLine::class);
    }
}