<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class InvoiceHelper
{
    /**
     * Generate nomor invoice yang unik
     * Format: INV-YYYYMMDD-0001
     */
    public static function generateInvoiceNumber()
    {
        $today = date('Ymd');
        $prefix = 'INV-' . $today . '-';
        
        $lastInvoice = DB::table('invoice')
            ->where('NoInvoice', 'LIKE', $prefix . '%')
            ->orderBy('NoInvoice', 'desc')
            ->first();
        
        if ($lastInvoice) {
            $lastNum = intval(substr($lastInvoice->NoInvoice, -4));
            $newNum = $lastNum + 1;
        } else {
            $newNum = 1;
        }
        
        return $prefix . str_pad($newNum, 4, '0', STR_PAD_LEFT);
    }
}
