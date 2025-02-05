<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Foundation\Validation\ValidatesRequests;

class MainController extends Controller
{
    use ValidatesRequests;
    public function index()
    {
        return view("home", [
            'title' => 'Home',
            'message' => 'Selamat datang di halaman home. Ini pesan dari controller'
        ]);
    }

    public function about()
    {
        return view("about", [
            'title' => 'About Us',
            'message' => 'Ini adalah deskripsi singkat tentang website dari controller.'
        ]);
    }

    public function contact()
    {
        return view('contact', [
            'title' => 'Contact Us',
            'message' => 'Isi formulir di bawah ini untuk menghubungi kami.'
        ]);
    }

    public function submitContact(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi brow',
            'max' => ':attribute maksimal :max karakter ya bray',
            'string' => ':attribute harus berupa teks ya bro',
            'email' => 'Email tidak valid bro'
        ];

        $validatedData = $this->validate($request, [
            'name' => 'required|string|max:2',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'pesan' => 'required|string'
        ], $messages);

        session()->flash('sukses', 'Masuk datamu');
        session()->flash('data', $validatedData); 

        return redirect()->route('contact');
    }
}
