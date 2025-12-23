<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlatBerat extends Model
{
    protected $table = 'alatBerat';
    protected $primaryKey = 'IdAlatBerat';
    public $timestamps = false;

    protected $fillable = [
        'NamaAlatBerat',
        'HargaPerHari',
    ];

    // Relasi ke InvoiceDetail
    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class, 'IdAlatBerat');
    }
}
