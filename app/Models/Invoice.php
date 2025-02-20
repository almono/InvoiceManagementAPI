<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

use App\Models\InvoiceProductLine;

class Invoice extends Model
{
    protected $table        = 'invoices';
    protected $primaryKey   = 'id';
    protected $keyType      = 'string';
    public $incrementing    = false;
    protected $fillable     = ['customer_name', 'customer_email', 'status', 'created_at', 'updated_at'];

    public function productLine(): HasMany
    {
        return $this->hasMany(InvoiceProductLine::class);
    }

    // To generate new UUID
    public static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            // Generate UUID for the id field when creating the record
            if (empty($invoice->id)) {
                $invoice->id = Str::uuid(); // Laravel helper to generate UUID
            }
        });
    }
}