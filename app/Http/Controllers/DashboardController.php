<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $currentMonth = $today->month;
        $currentYear = $today->year;

        // Count invoices today
        $invoicesToday = DB::table('invoice')
            ->whereDate('Tanggal', $today)
            ->count();

        // Get last invoice date
        $lastInvoice = DB::table('invoice')
            ->orderBy('Tanggal', 'desc')
            ->first();
        $lastDate = $lastInvoice ? $lastInvoice->Tanggal : 'Tidak ada data';

        // Count total customers
        $totalCustomers = DB::table('customer')->count();

        // Get total revenue this month
        $totalRevenue = DB::table('invoice')
            ->join('InvoiceDetail', 'invoice.NoInvoice', '=', 'InvoiceDetail.NoInvoice')
            ->whereMonth('invoice.Tanggal', $currentMonth)
            ->whereYear('invoice.Tanggal', $currentYear)
            ->sum('InvoiceDetail.SubtotalDetail');

        // Get sales/rentals today - Fixed query without JumlahHari
        $salesToday = DB::table('invoice')
            ->leftJoin('InvoiceDetail', 'invoice.NoInvoice', '=', 'InvoiceDetail.NoInvoice')
            ->leftJoin('alatBerat', 'InvoiceDetail.IdAlatBerat', '=', 'alatBerat.IdAlatBerat')
            ->whereDate('invoice.Tanggal', $today)
            ->select(
                DB::raw("COALESCE(alatBerat.NamaAlatBerat, 'Alat Berat') AS Produk"),
                DB::raw("COUNT(InvoiceDetail.IdAlatBerat) AS JumlahTerjual"),
                DB::raw("SUM(InvoiceDetail.SubtotalDetail) AS TotalHarga")
            )
            ->groupBy('InvoiceDetail.IdAlatBerat')
            ->orderBy('InvoiceDetail.IdAlatBerat', 'DESC')
            ->get()
            ->toArray();

        // Convert to array format for view
        $salesToday = array_map(function($item) {
            return [
                'Produk' => $item->Produk,
                'JumlahTerjual' => $item->JumlahTerjual ?? 0,
                'TotalHarga' => $item->TotalHarga ?? 0,
            ];
        }, $salesToday);

        return view('dashboard.index', [
            'invoicesToday' => $invoicesToday,
            'lastDate' => $lastDate,
            'totalCustomers' => $totalCustomers,
            'totalRevenue' => $totalRevenue ?? 0,
            'salesToday' => $salesToday,
        ]);
    }
}
