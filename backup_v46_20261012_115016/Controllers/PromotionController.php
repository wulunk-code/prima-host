<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->get();

        return view(
            'admin.promotions.index',
            compact('promotions')
        );
    }

    public function create()
    {
        return view(
            'admin.promotions.create'
        );
    }

    public function store(Request $request)
    {
        $image = null;

        if($request->hasFile('image'))
        {
            $image = $request->file('image')
                ->store(
                    'promotions',
                    'public'
                );
        }

        Promotion::create([
            'title'=>$request->title,
            'image'=>$image,
            'link'=>$request->link,
            'is_active'=>1
        ]);

        return redirect(
            '/admin/promotions'
        );
    }

    public function delete($id)
    {
        Promotion::destroy($id);

        return back();
    }
}