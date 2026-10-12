<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->get();

        return view(
            'admin.vouchers.index',
            compact('vouchers')
        );
    }

    public function create()
    {
        return view(
            'admin.vouchers.create'
        );
    }

    public function store(Request $request)
    {
        Voucher::create([

            'code'       => strtoupper($request->code),
            'discount'   => $request->discount,
            'expired_at' => $request->expired_at,
            'is_active'  => true

        ]);

        return redirect('/admin/vouchers');
    }

    public function delete($id)
    {
        Voucher::destroy($id);

        return back();
    }
}