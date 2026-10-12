<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN MEMBER
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $members = Member::latest()->paginate(20);

        return view(
            'admin_member',
            compact('members')
        );
    }

    public function create()
    {
        return view('member_tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'nullable|email',
            'password' => 'required'
        ]);

        Member::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'password' => bcrypt($request->password)
        ]);

        return redirect('/admin/member')
            ->with('success', 'Member berhasil ditambahkan');
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);

        return view(
            'member_edit',
            compact('member')
        );
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'birth_date' => $request->birth_date
        ];

        if (!empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        }

        $member->update($data);

        return redirect('/admin/member')
            ->with('success', 'Member berhasil diupdate');
    }

    public function destroy($id)
    {
        Member::destroy($id);

        return redirect('/admin/member')
            ->with('success', 'Member berhasil dihapus');
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER MEMBER
    |--------------------------------------------------------------------------
    */

    public function register()
    {
        return view('member_register');
    }

    public function registerProcess(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:members',
            'password' => 'required|min:4'
        ]);

        Member::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'password' => bcrypt($request->password)
        ]);

        return redirect('/member/login')
            ->with(
                'success',
                'Pendaftaran berhasil, silakan login'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN MEMBER
    |--------------------------------------------------------------------------
    */

    public function login()
    {
        return view('member_login');
    }

    public function loginProcess(Request $request)
    {
        $member = Member::where(
            'phone',
            $request->phone
        )->first();

        if (!$member) {
            return back()->with(
                'error',
                'Nomor WhatsApp tidak ditemukan'
            );
        }

        if (
            !password_verify(
                $request->password,
                $member->password
            )
        ) {
            return back()->with(
                'error',
                'Password salah'
            );
        }

        session([
            'member_id' => $member->id,
            'member_name' => $member->name
        ]);

        return redirect('/member/dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD MEMBER
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        if (!session('member_id')) {
            return redirect('/member/login');
        }

        $member = Member::find(
            session('member_id')
        );

        return view(
            'member_dashboard',
            compact('member')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout()
    {
        session()->flush();

        return redirect('/');
    }
    
    
    
    public function profile()
{
    if (!session('member_id')) {
        return redirect('/member/login');
    }

    $member = Member::findOrFail(session('member_id'));

    return view('member_profile', compact('member'));
}

public function updateProfile(Request $request)
{
    if (!session('member_id')) {
        return redirect('/member/login');
    }

    $member = Member::findOrFail(session('member_id'));

    $member->name = $request->name;
    $member->phone = $request->phone;
    $member->email = $request->email;
    $member->address = $request->address;

    if (!empty($request->password)) {
        $member->password = bcrypt($request->password);
    }

    $member->save();

    return redirect('/member/profile')
        ->with('success', 'Profil berhasil diperbarui');
}


}