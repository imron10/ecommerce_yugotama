<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required_without:phone', 'nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required_without:email', 'nullable', 'string', 'max:20', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
        ], [
            'email.required_without' => 'Email atau nomor HP wajib diisi.',
            'phone.required_without' => 'Email atau nomor HP wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar. Silakan login.',
            'phone.unique' => 'Nomor HP ini sudah terdaftar. Silakan login.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email ?? ($request->phone ? null : $request->email),
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'buyer',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('produk.katalog', absolute: false));
    }
}
