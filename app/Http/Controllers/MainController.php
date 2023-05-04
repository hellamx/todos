<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {

        if (Auth::check()) {
            return view('dashboard', [
                'todos' => Auth::user()->todos()->where('status', '=', '0')->orderBy('id', 'desc')->get(),
                'history' => Auth::user()->todos->where('status', '=', '1')
            ]);
        } else {
            return view('dashboard');
        }

    }
}
