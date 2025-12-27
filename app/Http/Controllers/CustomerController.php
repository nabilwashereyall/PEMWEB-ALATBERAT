<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function registerStore(Request $request)
    {
        $data = $request->validate([
            'NamaCustomer' => 'required|string|max:100',
            'Email' => 'nullable|email|unique:customer,Email',
            'NoTelepon' => 'nullable|string|max:15',
            'Alamat' => 'nullable|string',
            'Kota' => 'nullable|string|max:50',
        ]);

        $data['IdUser'] = auth()->id();
        $data['CreatedAt'] = now();
        $data['UpdatedAt'] = now();

        DB::table('customer')->insert($data);

        return redirect('/customer-order')->with('success', 'Registrasi customer berhasil!');
    }
}
