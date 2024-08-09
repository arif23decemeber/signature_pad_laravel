<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $perusahaan = Perusahaan::get();
        return view('web.pages.home', ['perusahaan'=>$perusahaan]);
    }

    public function perusahaan() {
        return view('web.pages.perusahaan');
    }

    public function store(Request $request) {
        Perusahaan::create($request->all());
        return redirect()->route('perusahaan');
    }
}
