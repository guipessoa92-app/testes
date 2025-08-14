<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Exibe a página principal (home) da aplicação.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('home');
    }
}