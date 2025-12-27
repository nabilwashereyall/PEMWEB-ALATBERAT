<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Helpers\InvoiceHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\CustomerOrderController;


// ============================================================
// PUBLIC ROUTES
// ============================================================

Route::get('/', function () {
    return view('welcome');
})->name('home');

// ============================================================
// AUTH ROUTES (Login & Register)
// ============================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
    
    Route::post('/register', function () {
        $data = request()->validate([
            'username' => 'required|string|min:3|unique:users,Username',
            'email' => 'required|email|unique:users,Email',
            'password' => 'required|string|min:6|confirmed',
            'NoTelepon' => 'required|string|max:15',
            'Alamat' => 'required|string',
            'Kota' => 'required|string|max:50',
        ]);
    
        $idUser = DB::table('users')->insertGetId([
            'Username' => $data['username'],
            'Email' => $data['email'],
            'Password' => Hash::make($data['password']),
            'Role' => 'user',
            'IsActive' => 1,
            'NoTelepon' => $data['NoTelepon'],
            'Alamat' => $data['Alamat'],
            'Kota' => $data['Kota'],
            'CreatedAt' => now(),
            'UpdatedAt' => now(),
        ], 'IdUser');
    
        DB::table('customer')->insert([
            'NamaCustomer' => $data['username'],
            'Email' => $data['email'],
            'IdUser' => $idUser,
            'NoTelepon' => $data['NoTelepon'],
            'Alamat' => $data['Alamat'],
            'Kota' => $data['Kota'],
            'CreatedAt' => now(),
            'UpdatedAt' => now(),
        ]);
    
        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login');
    })->name('register.post');
    
    Route::post('/customer/register-store', [CustomerController::class, 'registerStore'])->name('customer.register-store');
});

// ============================================================
// LOGOUT ROUTE
// ============================================================
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================================
// PROTECTED ROUTES (Require Login + Role Check)
// ============================================================
Route::middleware('App\Http\Middleware\CheckUserRole')->group(function () {
    
    // ============================================================
    // CUSTOMER REGISTRATION ROUTE
    // ============================================================
    Route::post('/customer/register-store', [CustomerController::class, 'registerStore'])->name('customer.register-store');
    
// ============================================================
// CUSTOMER ORDER ROUTES
// ============================================================

Route::get('/customer-order', function () {
    // data alat untuk pilihan di form
    $alatBerat = DB::table('AlatBerat')->get();

    // cari IdCustomer dari user yang login
    $idCustomer = DB::table('customer')
        ->where('IdUser', session('user_id'))
        ->value('IdCustomer');

    // kalau customer belum terdaftar, kirim view tanpa orders
    if (!$idCustomer) {
        $orders = collect(); // koleksi kosong
    } else {
        $orders = DB::table('PendingOrder')
            ->leftJoin('PendingOrderDetail', 'PendingOrder.IdPendingOrder', '=', 'PendingOrderDetail.IdPendingOrder')
            ->leftJoin('AlatBerat', 'PendingOrderDetail.IdAlatBerat', '=', 'AlatBerat.IdAlatBerat')
            ->where('PendingOrder.IdCustomer', $idCustomer)
            ->orderBy('PendingOrder.Tanggal', 'desc')
            ->select(
                'PendingOrder.*',
                'PendingOrderDetail.TanggalAwalSewa',
                'PendingOrderDetail.TanggalAkhirSewa',
                'PendingOrderDetail.DurasiHari',
                'PendingOrderDetail.SubtotalDetail',
                'AlatBerat.NamaAlatBerat'
            )
            ->paginate(10);
    }

    return view('customer-order.index', [
        'alatBerat' => $alatBerat,
        'orders'    => $orders,
    ]);
})->name('customer-order.index');

Route::post('/customer-order', function () {
    $data = request()->validate([
        'IdAlatBerat' => 'required|exists:AlatBerat,IdAlatBerat',
        'TanggalAwalSewa' => 'required|date',
        'TanggalAkhirSewa' => 'required|date|after:TanggalAwalSewa',
        'Account' => 'required|string|exists:Bank,Account',
    ]);

    $lastOrder = DB::table('PendingOrder')->orderBy('NoOrder', 'desc')->first();
    $lastNum = $lastOrder ? intval(substr($lastOrder->NoOrder, 3)) : 0;
    $noOrder = 'ORD' . str_pad($lastNum + 1, 6, '0', STR_PAD_LEFT);

    $customer = DB::table('customer')
        ->where('IdUser', session('user_id'))
        ->first();

    if (!$customer) {
        return back()->with('error', 'Data customer tidak ditemukan');
    }

    $idCustomer = $customer->IdCustomer;

    try {
        DB::beginTransaction();

        DB::table('PendingOrder')->insert([
            'NoOrder' => $noOrder,
            'IdCustomer' => $idCustomer,
            'Tanggal' => now(),
            'Status' => 'Pending',
            'CreatedAt' => now(),
            'UpdatedAt' => now(),
        ]);

        $idPendingOrder = DB::table('PendingOrder')
            ->where('NoOrder', $noOrder)
            ->value('IdPendingOrder');

        $alat = DB::table('AlatBerat')
            ->where('IdAlatBerat', $data['IdAlatBerat'])
            ->first();

        $awal = \Carbon\Carbon::createFromFormat('Y-m-d', $data['TanggalAwalSewa']);
        $akhir = \Carbon\Carbon::createFromFormat('Y-m-d', $data['TanggalAkhirSewa']);
        $durasi = max(1, $akhir->diffInDays($awal) + 1);

        $hargaSewa = (float) ($alat->HargaSewa ?? 0);
        $subtotal = max(0, $hargaSewa * $durasi);

        DB::table('PendingOrderDetail')->insert([
            'IdPendingOrder' => $idPendingOrder,
            'IdAlatBerat' => $data['IdAlatBerat'],
            'Account' => $data['Account'],
            'TanggalAwalSewa' => $data['TanggalAwalSewa'],
            'TanggalAkhirSewa' => $data['TanggalAkhirSewa'],
            'DurasiHari' => (int) $durasi,
            'SubtotalDetail' => (float) $subtotal,
            'CreatedAt' => now(),
            'UpdatedAt' => now(),
        ]);

        DB::commit();

        return redirect()->route('customer-order.index')
            ->with('success', 'Pesanan berhasil dibuat. No Order: ' . $noOrder);

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal menambahkan pesanan: ' . $e->getMessage());
    }
})->name('customer-order.store');



    // ============================================================
    // DASHBOARD ROUTE
    // ============================================================
    
    Route::get('/dashboard', function () {
        $today = date('Y-m-d');
        $currentMonth = date('m');
        $currentYear = date('Y');

        $invoicesToday = DB::table('invoice')
            ->whereDate('Tanggal', $today)
            ->count();

        $lastInvoice = DB::table('invoice')
            ->orderBy('Tanggal', 'desc')
            ->first();
        $lastDate = $lastInvoice ? $lastInvoice->Tanggal : 'Tidak ada data';

        $totalCustomers = DB::table('customer')->count();

        $totalPendingOrders = DB::table('PendingOrder')
            ->where('Status', 'Pending')
            ->count();

        $totalRevenue = (float) (DB::table('invoice')
            ->whereMonth('Tanggal', $currentMonth)
            ->whereYear('Tanggal', $currentYear)
            ->sum('TotalAmount') ?? 0);

        $salesToday = DB::select("
            SELECT 
                i.NoInvoice,
                c.NamaCustomer,
                COALESCE(ab.NamaAlatBerat, 'Alat Berat') AS Produk,
                COUNT(DISTINCT id.IdAlatBerat) AS JumlahTerjual,
                SUM(id.SubtotalDetail) AS TotalHarga,
                i.Tanggal,
                i.CreatedAt,
                i.UpdatedAt
            FROM invoice i
            LEFT JOIN customer c ON i.IdCustomer = c.IdCustomer
            LEFT JOIN InvoiceDetail id ON i.NoInvoice = id.NoInvoice
            LEFT JOIN alatBerat ab ON id.IdAlatBerat = ab.IdAlatBerat
            WHERE DATE(i.Tanggal) = ?
            GROUP BY i.NoInvoice, c.NamaCustomer, id.IdAlatBerat, ab.NamaAlatBerat, i.Tanggal, i.CreatedAt, i.UpdatedAt
            ORDER BY i.CreatedAt DESC
        ", [$today]);

        $salesToday = array_map(function($item) {
            return [
                'NoInvoice' => $item->NoInvoice,
                'NamaCustomer' => $item->NamaCustomer ?? 'N/A',
                'Produk' => $item->Produk,
                'JumlahTerjual' => (int) ($item->JumlahTerjual ?? 0),
                'TotalHarga' => (float) ($item->TotalHarga ?? 0),
                'Tanggal' => $item->Tanggal,
                'CreatedAt' => $item->CreatedAt,
                'UpdatedAt' => $item->UpdatedAt,
            ];
        }, $salesToday);

        return view('dashboard.index', [
            'invoicesToday' => $invoicesToday,
            'lastDate' => $lastDate,
            'totalCustomers' => $totalCustomers,
            'totalPendingOrders' => $totalPendingOrders,
            'totalRevenue' => $totalRevenue,
            'salesToday' => $salesToday,
        ]);
    })->name('dashboard');

    // ============================================================
    // INVOICE ROUTES
    // ============================================================

    Route::get('/invoice', function () {
        $invoices = DB::table('invoice')
            ->leftJoin('customer', 'invoice.IdCustomer', '=', 'customer.IdCustomer')
            ->select('invoice.*', 'customer.NamaCustomer')
            ->paginate(10);
        
        return view('invoice.index', ['invoices' => $invoices]);
    })->name('invoice.index');

    Route::get('/invoice/create', function () {
        $customers = DB::table('customer')->get();
        $accounts = DB::table('Bank')->select('Account', 'NamaBank')->get();
        
        return view('invoice.create', [
            'customers' => $customers,
            'accounts' => $accounts,
        ]);
    })->name('invoice.create');

    Route::post('/invoice', function () {
        $data = request()->validate([
            'NoInvoice' => 'required|string|unique:invoice,NoInvoice',
            'IdCustomer' => 'required|integer|exists:customer,IdCustomer',
            'Account' => 'required|string|exists:Bank,Account',
            'Tanggal' => 'required|date_format:Y-m-d\TH:i',
        ]);

        $data['Tanggal'] = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $data['Tanggal'])->format('Y-m-d H:i:s');
        $data['IdStaff'] = session('user_id') ?? 1;
        $data['TotalAmount'] = 0;
        $data['Status'] = 'Pending';

        DB::table('invoice')->insert($data);

        return redirect('/invoice')->with('success', 'Invoice berhasil dibuat');
    })->name('invoice.store');

    Route::get('/invoice/{NoInvoice}', function ($NoInvoice) {
        $invoice = DB::table('invoice')->where('NoInvoice', $NoInvoice)->first();
        if (!$invoice) abort(404);

        $customer = DB::table('customer')->where('IdCustomer', $invoice->IdCustomer)->first();
        $items = DB::table('InvoiceDetail')
            ->leftJoin('alatBerat', 'InvoiceDetail.IdAlatBerat', '=', 'alatBerat.IdAlatBerat')
            ->where('InvoiceDetail.NoInvoice', $NoInvoice)
            ->get();

        $subtotal = (float) ($items->sum('SubtotalDetail') ?? 0);
        $ppn = $subtotal * 0.10;
        $total = max(0, $subtotal + $ppn);

        DB::table('invoice')
            ->where('NoInvoice', $NoInvoice)
            ->update([
                'TotalAmount' => $total,
                'UpdatedAt' => now()
            ]);

        return view('invoicedetail.show', [
            'invoice' => $invoice,
            'customer' => $customer,
            'items' => $items,
            'subtotal' => $subtotal,
            'ppn' => $ppn,
            'total' => $total
        ]);
    })->name('invoice.show');

    Route::get('/invoice/{NoInvoice}/print', function ($NoInvoice) {
        $invoice = DB::table('invoice')->where('NoInvoice', $NoInvoice)->first();
        if (!$invoice) abort(404);

        $customer = DB::table('customer')->where('IdCustomer', $invoice->IdCustomer)->first();
        $items = DB::table('InvoiceDetail')
            ->leftJoin('alatBerat', 'InvoiceDetail.IdAlatBerat', '=', 'alatBerat.IdAlatBerat')
            ->where('InvoiceDetail.NoInvoice', $NoInvoice)
            ->get();

        $subtotal = (float) ($items->sum('SubtotalDetail') ?? 0);
        $ppn = $subtotal * 0.10;

        return view('invoicedetail.print', [
            'invoice' => $invoice,
            'customer' => $customer,
            'items' => $items,
            'subtotal' => $subtotal,
            'ppn' => $ppn,
        ]);
    })->name('invoice.print');

    Route::get('/invoice/{NoInvoice}/edit', function ($NoInvoice) {
        $invoice = DB::table('invoice')
            ->leftJoin('customer', 'invoice.IdCustomer', '=', 'customer.IdCustomer')
            ->select('invoice.*', 'customer.NamaCustomer')
            ->where('invoice.NoInvoice', $NoInvoice)
            ->first();
        
        if (!$invoice) abort(404);
        $customers = DB::table('customer')->get();
        
        return view('invoice.edit', [
            'invoice' => $invoice,
            'customers' => $customers
        ]);
    })->name('invoice.edit');

    Route::put('/invoice/{NoInvoice}', function ($NoInvoice) {
        $data = request()->validate([
            'IdCustomer' => 'required|integer',
            'Tanggal' => 'required|date',
        ]);

        $data['UpdatedAt'] = now();
        DB::table('invoice')
            ->where('NoInvoice', $NoInvoice)
            ->update($data);

        return redirect('/invoice')->with('success', 'Invoice berhasil diupdate');
    })->name('invoice.update');

    Route::delete('/invoice/{NoInvoice}', function ($NoInvoice) {
        DB::table('invoice')->where('NoInvoice', $NoInvoice)->delete();
        return redirect('/invoice')->with('success', 'Invoice berhasil dihapus');
    })->name('invoice.destroy');

    // ============================================================
    // INVOICE DETAIL ROUTES
    // ============================================================

    Route::get('/invoice/{NoInvoice}/detail/create', function ($NoInvoice) {
        $invoice = DB::table('invoice')->where('NoInvoice', $NoInvoice)->first();
        if (!$invoice) abort(404);
        $alatBerat = DB::table('alatBerat')->get();
        return view('invoicedetail.create', [
            'invoice' => $invoice,
            'alatBerat' => $alatBerat,
        ]);
    })->name('invoicedetail.create');

    Route::post('/invoice/{NoInvoice}/detail', function ($NoInvoice) {
        $data = request()->validate([
            'IdAlatBerat' => 'required|integer|exists:alatBerat,IdAlatBerat',
            'TanggalAwalSewa' => 'required|date',
            'TanggalAkhirSewa' => 'required|date|after:TanggalAwalSewa',
            'SubtotalDetail' => 'required|numeric|min:0',
        ]);

        $data['NoInvoice'] = $NoInvoice;
        $start = \Carbon\Carbon::createFromFormat('Y-m-d', $data['TanggalAwalSewa']);
        $end = \Carbon\Carbon::createFromFormat('Y-m-d', $data['TanggalAkhirSewa']);
        $data['DurasiHari'] = max(1, $end->diffInDays($start) + 1);

        DB::table('InvoiceDetail')->insert($data);
        return redirect("/invoice/$NoInvoice")->with('success', 'Item berhasil ditambahkan');
    })->name('invoicedetail.store');

    Route::get('/invoice/{NoInvoice}/detail/{IdAlatBerat}/edit', function ($NoInvoice, $IdAlatBerat) {
        $invoice = DB::table('invoice')->where('NoInvoice', $NoInvoice)->first();
        if (!$invoice) abort(404);

        $item = DB::table('InvoiceDetail')
            ->where('NoInvoice', $NoInvoice)
            ->where('IdAlatBerat', $IdAlatBerat)
            ->first();
        if (!$item) abort(404);

        $alatBerat = DB::table('alatBerat')->get();
        return view('invoicedetail.edit', [
            'invoice' => $invoice,
            'item' => $item,
            'alatBerat' => $alatBerat,
        ]);
    })->name('invoicedetail.edit');

    Route::put('/invoice/{NoInvoice}/detail/{IdAlatBerat}', function ($NoInvoice, $IdAlatBerat) {
        $data = request()->validate([
            'IdAlatBerat' => 'required|integer|exists:alatBerat,IdAlatBerat',
            'TanggalAwalSewa' => 'required|date',
            'TanggalAkhirSewa' => 'required|date|after:TanggalAwalSewa',
            'SubtotalDetail' => 'required|numeric|min:0',
        ]);

        $start = \Carbon\Carbon::createFromFormat('Y-m-d', $data['TanggalAwalSewa']);
        $end = \Carbon\Carbon::createFromFormat('Y-m-d', $data['TanggalAkhirSewa']);
        $data['DurasiHari'] = max(1, $end->diffInDays($start) + 1);

        DB::table('InvoiceDetail')
            ->where('NoInvoice', $NoInvoice)
            ->where('IdAlatBerat', $IdAlatBerat)
            ->update($data);

        return redirect("/invoice/$NoInvoice")->with('success', 'Item berhasil diupdate');
    })->name('invoicedetail.update');

    Route::delete('/invoice/{NoInvoice}/detail/{IdAlatBerat}', function ($NoInvoice, $IdAlatBerat) {
        DB::table('InvoiceDetail')
            ->where('NoInvoice', $NoInvoice)
            ->where('IdAlatBerat', $IdAlatBerat)
            ->delete();
    
        $subtotal = (float) (DB::table('InvoiceDetail')
            ->where('NoInvoice', $NoInvoice)
            ->sum('SubtotalDetail') ?? 0);
        $ppn = $subtotal * 0.10;
        $total = max(0, $subtotal + $ppn);
    
        DB::table('invoice')
            ->where('NoInvoice', $NoInvoice)
            ->update([
                'TotalAmount' => $total,
                'UpdatedAt' => now(),
            ]);
    
        return redirect()->route('invoice.show', $NoInvoice)
            ->with('success', 'Item berhasil dihapus');
    })->name('invoicedetail.destroy');
    

    // ============================================================
    // CUSTOMER ROUTES
    // ============================================================

    Route::get('/customer', function () {
        $customers = DB::table('customer')->paginate(10);
        return view('customer.index', ['customers' => $customers]);
    })->name('customer.index');

    Route::get('/customer/create', function () {
        return view('customer.create');
    })->name('customer.create');

    Route::post('/customer', function () {
        $data = request()->validate([
            'NamaCustomer' => 'required|string|max:100',
            'Email' => 'nullable|email|max:100|unique:customer,Email',
            'NoTelepon' => 'nullable|string|max:15',
            'Alamat' => 'nullable|string',
            'Kota' => 'nullable|string|max:50',
        ]);

        DB::table('customer')->insert($data);
        return redirect('/customer')->with('success', 'Customer berhasil ditambahkan');
    })->name('customer.store');

    Route::get('/customer/{IdCustomer}', function ($IdCustomer) {
        $customer = DB::table('customer')->where('IdCustomer', $IdCustomer)->first();
        if (!$customer) abort(404);
        return view('customer.show', ['customer' => $customer]);
    })->name('customer.show');

    Route::get('/customer/{IdCustomer}/edit', function ($IdCustomer) {
        $customer = DB::table('customer')->where('IdCustomer', $IdCustomer)->first();
        if (!$customer) abort(404);
        return view('customer.edit', ['customer' => $customer]);
    })->name('customer.edit');

    Route::put('/customer/{IdCustomer}', function ($IdCustomer) {
        $data = request()->validate([
            'NamaCustomer' => 'required|string|max:100',
            'Email' => 'nullable|email|max:100|unique:customer,Email,'.$IdCustomer.',IdCustomer',
            'NoTelepon' => 'nullable|string|max:15',
            'Alamat' => 'nullable|string',
            'Kota' => 'nullable|string|max:50',
        ]);

        $data['UpdatedAt'] = now();
        DB::table('customer')->where('IdCustomer', $IdCustomer)->update($data);
        return redirect('/customer')->with('success', 'Customer berhasil diupdate');
    })->name('customer.update');

    Route::delete('/customer/{IdCustomer}', function ($IdCustomer) {
        DB::table('customer')->where('IdCustomer', $IdCustomer)->delete();
        return redirect('/customer')->with('success', 'Customer berhasil dihapus');
    })->name('customer.destroy');

    // ============================================================
    // STAFF ROUTES
    // ============================================================

    Route::get('/staff', function () {
        $staff = DB::table('Staff')->paginate(10);
        return view('staff.index', ['staff' => $staff]);
    })->name('staff.index');

    Route::get('/staff/create', function () {
        return view('staff.create');
    })->name('staff.create');

    Route::post('/staff', function () {
        $data = request()->validate([
            'NamaStaff' => 'required|string|max:100',
            'Email' => 'required|email|unique:Staff,Email',
            'NoTelepon' => 'nullable|string|max:15',
            'Alamat' => 'nullable|string',
        ]);

        DB::table('Staff')->insert($data);
        return redirect('/staff')->with('success', 'Staff berhasil ditambahkan');
    })->name('staff.store');

    Route::get('/staff/{IdStaff}', function ($IdStaff) {
        $staff = DB::table('Staff')->where('IdStaff', $IdStaff)->first();
        if (!$staff) abort(404);
        return view('staff.show', ['staff' => $staff]);
    })->name('staff.show');

    Route::get('/staff/{IdStaff}/edit', function ($IdStaff) {
        $staff = DB::table('Staff')->where('IdStaff', $IdStaff)->first();
        if (!$staff) abort(404);
        return view('staff.edit', ['staff' => $staff]);
    })->name('staff.edit');

    Route::put('/staff/{IdStaff}', function ($IdStaff) {
        $data = request()->validate([
            'NamaStaff' => 'required|string|max:100',
            'Email' => 'required|email|unique:Staff,Email,'.$IdStaff.',IdStaff',
            'NoTelepon' => 'nullable|string|max:15',
            'Alamat' => 'nullable|string',
        ]);

        $data['UpdatedAt'] = now();
        DB::table('Staff')->where('IdStaff', $IdStaff)->update($data);
        return redirect('/staff')->with('success', 'Staff berhasil diupdate');
    })->name('staff.update');

    Route::delete('/staff/{IdStaff}', function ($IdStaff) {
        DB::table('Staff')->where('IdStaff', $IdStaff)->delete();
        return redirect('/staff')->with('success', 'Staff berhasil dihapus');
    })->name('staff.destroy');

    // ============================================================
    // BANK ROUTES
    // ============================================================

    Route::get('/bank', function () {
        $banks = DB::table('Bank')->paginate(10);
        return view('bank.index', ['banks' => $banks]);
    })->name('bank.index');

    Route::get('/bank/create', function () {
        return view('bank.create');
    })->name('bank.create');

    Route::post('/bank', function () {
        $data = request()->validate([
            'Account' => 'required|string|max:50|unique:Bank,Account',
            'NamaBank' => 'required|string|max:100',
            'NomorRekening' => 'nullable|string|max:50',
        ]);

        DB::table('Bank')->insert($data);
        return redirect('/bank')->with('success', 'Bank berhasil ditambahkan');
    })->name('bank.store');

    Route::get('/bank/{Account}', function ($Account) {
        $bank = DB::table('Bank')->where('Account', $Account)->first();
        if (!$bank) abort(404);
        return view('bank.show', ['bank' => $bank]);
    })->name('bank.show');

    Route::get('/bank/{Account}/edit', function ($Account) {
        $bank = DB::table('Bank')->where('Account', $Account)->first();
        if (!$bank) abort(404);
        return view('bank.edit', ['bank' => $bank]);
    })->name('bank.edit');

    Route::put('/bank/{Account}', function ($Account) {
        $data = request()->validate([
            'NamaBank' => 'required|string|max:100',
            'NomorRekening' => 'nullable|string|max:50',
        ]);

        $data['UpdatedAt'] = now();
        DB::table('Bank')->where('Account', $Account)->update($data);
        return redirect('/bank')->with('success', 'Bank berhasil diupdate');
    })->name('bank.update');

    Route::delete('/bank/{Account}', function ($Account) {
        DB::table('Bank')->where('Account', $Account)->delete();
        return redirect('/bank')->with('success', 'Bank berhasil dihapus');
    })->name('bank.destroy');

    // ============================================================
    // ALAT BERAT ROUTES
    // ============================================================

    Route::get('/alat-berat', function () {
        $alatBerat = DB::table('AlatBerat')->paginate(10);
        return view('alat-berat.index', ['alatBerat' => $alatBerat]);
    })->name('alat-berat.index');

    Route::get('/alat-berat/create', function () {
        return view('alat-berat.create');
    })->name('alat-berat.create');

    Route::post('/alat-berat', function () {
        $data = request()->validate([
            'NamaAlatBerat' => 'required|string|max:100',
            'Tipe' => 'nullable|string|max:100',
            'Spesifikasi' => 'nullable|string',
            'HargaSewa' => 'required|numeric|min:0',
            'Kondisi' => 'nullable|string|max:50',
        ]);

        DB::table('AlatBerat')->insert($data);
        return redirect('/alat-berat')->with('success', 'Alat Berat berhasil ditambahkan');
    })->name('alat-berat.store');

    Route::get('/alat-berat/{IdAlatBerat}', function ($IdAlatBerat) {
        $alatBerat = DB::table('AlatBerat')->where('IdAlatBerat', $IdAlatBerat)->first();
        if (!$alatBerat) abort(404);
        return view('alat-berat.show', ['alatBerat' => $alatBerat]);
    })->name('alat-berat.show');

    Route::get('/alat-berat/{IdAlatBerat}/edit', function ($IdAlatBerat) {
        $alatBerat = DB::table('AlatBerat')->where('IdAlatBerat', $IdAlatBerat)->first();
        if (!$alatBerat) abort(404);
        return view('alat-berat.edit', ['alatBerat' => $alatBerat]);
    })->name('alat-berat.edit');

    Route::put('/alat-berat/{IdAlatBerat}', function ($IdAlatBerat) {
        $data = request()->validate([
            'NamaAlatBerat' => 'required|string|max:100',
            'Tipe' => 'nullable|string|max:100',
            'Spesifikasi' => 'nullable|string',
            'HargaSewa' => 'required|numeric|min:0',
            'Kondisi' => 'nullable|string|max:50',
        ]);

        $data['UpdatedAt'] = now();
        DB::table('AlatBerat')->where('IdAlatBerat', $IdAlatBerat)->update($data);
        return redirect('/alat-berat')->with('success', 'Alat Berat berhasil diupdate');
    })->name('alat-berat.update');

    Route::delete('/alat-berat/{IdAlatBerat}', function ($IdAlatBerat) {
        DB::table('AlatBerat')->where('IdAlatBerat', $IdAlatBerat)->delete();
        return redirect('/alat-berat')->with('success', 'Alat Berat berhasil dihapus');
    })->name('alat-berat.destroy');

    // ============================================================
    // PENDING ORDER ROUTES
    // ============================================================

    Route::get('/pending-order', function () {
        $pendingOrders = DB::table('PendingOrder')
            ->leftJoin('customer', 'PendingOrder.IdCustomer', '=', 'customer.IdCustomer')
            ->select(
                'PendingOrder.*',
                'customer.NamaCustomer',
                'customer.Email',
                'customer.NoTelepon'
            )
            ->where('PendingOrder.Status', 'Pending')
            ->orderBy('PendingOrder.Tanggal', 'desc')
            ->paginate(10);

        return view('pending-order.index', ['pendingOrders' => $pendingOrders]);
    })->name('pending-order.index');

    Route::get('/pending-order/{IdPendingOrder}', function ($IdPendingOrder) {
        $order = DB::table('PendingOrder')
            ->leftJoin('customer', 'PendingOrder.IdCustomer', '=', 'customer.IdCustomer')
            ->where('PendingOrder.IdPendingOrder', $IdPendingOrder)
            ->first();

        if (!$order) abort(404);

        $items = DB::table('PendingOrderDetail')
            ->leftJoin('alatBerat', 'PendingOrderDetail.IdAlatBerat', '=', 'alatBerat.IdAlatBerat')
            ->where('PendingOrderDetail.IdPendingOrder', $IdPendingOrder)
            ->get();

        $subtotal = (float) ($items->sum('SubtotalDetail') ?? 0);
        $ppn = $subtotal * 0.10;
        $total = max(0, $subtotal + $ppn);

        return view('pending-order.show', [
            'order' => $order,
            'items' => $items,
            'subtotal' => $subtotal,
            'ppn' => $ppn,
            'total' => $total,
        ]);
    })->name('pending-order.show');

    Route::post('/pending-order/{IdPendingOrder}/approve', function ($IdPendingOrder) {
        $pendingOrder = DB::table('PendingOrder')
            ->where('IdPendingOrder', $IdPendingOrder)
            ->first();
    
        if (!$pendingOrder) abort(404);
    
        try {
            DB::beginTransaction();
    
            $lastInvoice = DB::table('invoice')->orderBy('NoInvoice', 'desc')->first();
            $lastNum = $lastInvoice ? intval(substr($lastInvoice->NoInvoice, 3)) : 0;
            $noInvoice = 'INV' . str_pad($lastNum + 1, 6, '0', STR_PAD_LEFT);
    
            $pendingItems = DB::table('PendingOrderDetail')
                ->where('IdPendingOrder', $IdPendingOrder)
                ->get();
    
            $subtotal = (float) ($pendingItems->sum('SubtotalDetail') ?? 0);
            $ppn = $subtotal * 0.10;
            $total = max(0, $subtotal + $ppn);
    
            $account = $pendingItems->first()?->Account ?? 'DEFAULT';
    
            DB::table('invoice')->insert([
                'NoInvoice' => $noInvoice,
                'IdCustomer' => $pendingOrder->IdCustomer,
                'Tanggal' => now(),
                'Account' => $account,
                'TotalAmount' => $total,
                'Status' => 'Pending',
                'CreatedAt' => now(),
                'UpdatedAt' => now(),
            ]);
    
            foreach ($pendingItems as $item) {
                DB::table('InvoiceDetail')->insert([
                    'NoInvoice' => $noInvoice,
                    'IdAlatBerat' => $item->IdAlatBerat,
                    'TanggalAwalSewa' => $item->TanggalAwalSewa,
                    'TanggalAkhirSewa' => $item->TanggalAkhirSewa,
                    'DurasiHari' => $item->DurasiHari,
                    'SubtotalDetail' => $item->SubtotalDetail,
                    'CreatedAt' => now(),
                    'UpdatedAt' => now(),
                ]);
            }
    
            DB::table('PendingOrder')
                ->where('IdPendingOrder', $IdPendingOrder)
                ->update([
                    'Status' => 'Approved',
                    'UpdatedAt' => now(),
                ]);
    
            DB::commit();
    
            return redirect('/pending-order')
                ->with('success', 'Order berhasil di-approve dan convert ke Invoice ' . $noInvoice);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal approve order: ' . $e->getMessage());
        }
    })->name('pending-order.approve');
    
    Route::post('/pending-order/{IdPendingOrder}/reject', function ($IdPendingOrder) {
        $reason = request()->validate([
            'reason' => 'nullable|string|max:500'
        ]);

        DB::table('PendingOrder')
            ->where('IdPendingOrder', $IdPendingOrder)
            ->update([
                'Status' => 'Rejected',
                'Keterangan' => $reason['reason'] ?? null,
                'UpdatedAt' => now(),
            ]);

        return redirect('/pending-order')
            ->with('success', 'Order berhasil ditolak');
    })->name('pending-order.reject');

});

Route::get('/api/invoice/{NoInvoice}/total', function ($NoInvoice) {
    $invoice = DB::table('invoice')->where('NoInvoice', $NoInvoice)->first();
    
    if (!$invoice) {
        return response()->json(['total' => 0], 404);
    }

    // Hitung total dari items
    $items = DB::table('InvoiceDetail')
        ->where('NoInvoice', $NoInvoice)
        ->get();

    $subtotal = (float) ($items->sum('SubtotalDetail') ?? 0);
    $ppn = $subtotal * 0.10;
    $total = $subtotal + $ppn;

    return response()->json([
        'total' => $total,
        'subtotal' => $subtotal,
        'ppn' => $ppn,
        'items_count' => $items->count()
    ]);
})->name('api.invoice.total');

// ============================================================
// END OF ROUTES
// ============================================================
