<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();

        return view('admin_event', compact('events'));
    }

    public function create()
    {
        return view('event_tambah');
    }

    public function store(Request $request)
    {
        $gambar = null;

        if ($request->hasFile('image')) {

            $gambar = time() . '.jpg';

            $request->file('image')->move(
                public_path('uploads'),
                $gambar
            );
        }

        Event::create([
            'title'       => $request->title,
            'description' => $request->description,
            'location'    => $request->location,
            'event_date'  => $request->event_date,
            'image'       => $gambar,
            'is_active'   => 1
        ]);

        return redirect('/admin/event');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);

        return view('event_edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $gambar = $event->image;

        if ($request->hasFile('image')) {

            $gambar = time() . '.jpg';

            $request->file('image')->move(
                public_path('uploads'),
                $gambar
            );
        }

        $event->update([
            'title'       => $request->title,
            'description' => $request->description,
            'location'    => $request->location,
            'event_date'  => $request->event_date,
            'image'       => $gambar
        ]);

        return redirect('/admin/event');
    }

    public function destroy($id)
    {
        Event::destroy($id);

        return redirect('/admin/event');
    }
}