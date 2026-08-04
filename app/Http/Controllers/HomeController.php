<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil.
     */
    public function index()
    {
        return view('home');
    }
}
