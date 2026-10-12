<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->get();

        return view('admin_banner', compact('banners'));
    }

    public function create()
    {
        return view('banner_tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $ext = $request->file('image')
            ->getClientOriginalExtension();

        $gambar = time().'_'.rand(1000,9999).'.'.$ext;

        $request->file('image')->move(
            public_path('uploads'),
            $gambar
        );

        Banner::create([
            'title' => $request->title,
            'image' => $gambar,
            'is_active' => 1
        ]);

        return redirect('/admin/banner')
            ->with('success','Banner berhasil ditambahkan');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);

        return view('banner_edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $gambar = $banner->image;

        if ($request->hasFile('image')) {

            $ext = $request->file('image')
                ->getClientOriginalExtension();

            $gambar = time().'_'.rand(1000,9999).'.'.$ext;

            $request->file('image')->move(
                public_path('uploads'),
                $gambar
            );
        }

        $banner->update([
            'title' => $request->title,
            'image' => $gambar
        ]);

        return redirect('/admin/banner')
            ->with('success','Banner berhasil diubah');
    }

    public function destroy($id)
    {
        Banner::destroy($id);

        return redirect('/admin/banner')
            ->with('success','Banner berhasil dihapus');
    }
}