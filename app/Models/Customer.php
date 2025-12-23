<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'Customer';
    protected $primaryKey = 'IdCustomer';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $fillable = [
        'NamaCustomer',
        'Email',
        'NoHp',
        'Alamat',
    ];

    // Relationships
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'IdCustomer', 'IdCustomer');
    }
}
