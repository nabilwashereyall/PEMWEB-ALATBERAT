<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    // Tampilkan daftar alat berat untuk dipesan
    public function index()
    {
        $alatBerat = DB::table('AlatBerat')->paginate(10);

        return view('customer-order.index', [
            'alatBerat' => $alatBerat,
        ]);
    }

    // Simpan order dari customer
    public function store(Request $request)
    {
        $validated = $request->validate([
            'IdAlatBerat' => 'required|exists:AlatBerat,IdAlatBerat',
            'TanggalAwalSewa' => 'required|date',
            'TanggalAkhirSewa' => 'required|date|after:TanggalAwalSewa',
            'Account' => 'required|exists:Bank,Account',
        ]);

        // Ambil customer berdasarkan user yang login
        $customer = DB::table('customer')
            ->where('IdUser', session('user_id'))
            ->first();

        if (!$customer) {
            return back()->with('error', 'Data customer tidak ditemukan');
        }

        // Generate nomor order
        $lastOrder = DB::table('PendingOrder')
            ->orderBy('NoOrder', 'desc')
            ->first();
        $lastNum = $lastOrder ? intval(substr($lastOrder->NoOrder, 3)) : 0;
        $noOrder = 'ORD' . str_pad($lastNum + 1, 6, '0', STR_PAD_LEFT);

        try {
            DB::beginTransaction();

            // Buat pending order
            $pendingOrderId = DB::table('PendingOrder')->insertGetId([
                'NoOrder' => $noOrder,
                'IdCustomer' => $customer->IdCustomer,
                'Tanggal' => now(),
                'Status' => 'Pending',
                'CreatedAt' => now(),
                'UpdatedAt' => now(),
            ]);

            // Hitung durasi dan subtotal
            $awal = \Carbon\Carbon::createFromFormat('Y-m-d', $validated['TanggalAwalSewa']);
            $akhir = \Carbon\Carbon::createFromFormat('Y-m-d', $validated['TanggalAkhirSewa']);
            $durasi = max(1, $akhir->diffInDays($awal) + 1);

            $alat = DB::table('AlatBerat')
                ->where('IdAlatBerat', $validated['IdAlatBerat'])
                ->first();

            $hargaSewa = (float) ($alat->HargaSewa ?? 0);
            $subtotal = $hargaSewa * $durasi;

            // Buat pending order detail
            DB::table('PendingOrderDetail')->insert([
                'IdPendingOrder' => $pendingOrderId,
                'IdAlatBerat' => $validated['IdAlatBerat'],
                'TanggalAwalSewa' => $validated['TanggalAwalSewa'],
                'TanggalAkhirSewa' => $validated['TanggalAkhirSewa'],
                'DurasiHari' => (int) $durasi,
                'SubtotalDetail' => (float) $subtotal,
                'Account' => $validated['Account'],
                'CreatedAt' => now(),
                'UpdatedAt' => now(),
            ]);

            DB::commit();

            return redirect('/customer-order')
                ->with('success', 'Pesanan berhasil dibuat. No Order: ' . $noOrder);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }
}
