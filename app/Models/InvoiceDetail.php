<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    protected $table = 'InvoiceDetail';
    protected $primaryKey = 'IdDetail';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'NoInvoice',
        'IdAlatBerat',
        'TanggalAwalSewa',
        'TanggalAkhirSewa',
        'JumlahHari',
        'SubtotalDetail',
    ];

    // Relationships
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'NoInvoice', 'NoInvoice');
    }

    public function alatBerat()
    {
        return $this->belongsTo(AlatBerat::class, 'IdAlatBerat', 'IdAlatBerat');
    }
}
