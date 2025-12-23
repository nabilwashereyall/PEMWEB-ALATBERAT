<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'Invoice';
    protected $primaryKey = 'NoInvoice';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $fillable = [
        'NoInvoice',
        'IdStaff',
        'IdCustomer',
        'Tanggal',
        'SubTotal',
        'TotalAmount',
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'IdCustomer', 'IdCustomer');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'IdStaff', 'IdUser');
    }

    public function details()
    {
        return $this->hasMany(InvoiceDetail::class, 'NoInvoice', 'NoInvoice');
    }
}
