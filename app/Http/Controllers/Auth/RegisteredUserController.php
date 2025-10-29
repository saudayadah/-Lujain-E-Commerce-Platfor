<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Generate email if not provided (using phone number)
        $email = $request->email ?: $request->phone . '@lujaiin.local';

        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect to cart if there are items, otherwise home
        if (session()->has('cart') && !empty(session('cart'))) {
            return redirect()->route('cart.index')->with('success', 'تم إنشاء حسابك بنجاح! يمكنك الآن إتمام عملية الشراء.');
        }

        return redirect()->route('home')->with('success', 'تم إنشاء حسابك بنجاح!');
    }
}

