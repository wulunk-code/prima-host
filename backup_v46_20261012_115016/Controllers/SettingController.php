<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        return view(
            'admin.setting',
            compact('setting')
        );
    }

    public function update(Request $request)
    {
        $setting = Setting::first();

        if(!$setting)
        {
            $setting = new Setting();
        }

        if($request->hasFile('store_logo'))
        {
            $setting->store_logo =
                $request->file('store_logo')
                ->store('setting','public');
        }

        if($request->hasFile('qris_image'))
        {
            $setting->qris_image =
                $request->file('qris_image')
                ->store('setting','public');
        }

        $setting->store_name =
            $request->store_name;

        $setting->store_address =
            $request->store_address;

        $setting->store_phone =
            $request->store_phone;

        $setting->bank_name =
            $request->bank_name;

        $setting->bank_account =
            $request->bank_account;

        $setting->bank_holder =
            $request->bank_holder;

        $setting->shipping_cost =
            $request->shipping_cost;

        $setting->free_shipping_radius =
            $request->free_shipping_radius;

        $setting->save();

        return back()->with(
            'success',
            'Pengaturan berhasil disimpan'
        );
    }
}