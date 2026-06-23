<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function __construct()
    {
        // Block non-superadmins from accessing any method in this controller
        abort_if(auth()->check() && auth()->user()->role !== 'superadmin', 403, 'Akses Ditolak: Hanya SuperAdmin yang dapat mengelola panitia.');
    }

    public function index()
    {
        $users = User::latest()->get(); // Superadmin can see all users (admin and superadmin)
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Panitia baru berhasil ditambahkan.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->role === 'superadmin') {
            return back()->with('error', 'Akun SuperAdmin tidak dapat dihapus!');
        }

        $user->delete();
        return back()->with('success', 'Akun panitia berhasil dihapus.');
    }
}
