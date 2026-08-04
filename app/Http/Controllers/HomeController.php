<?php

namespace App\Http\Controllers;

use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        $event = Event::with('sessions')->first();

        return view('home', compact('event'));
    }
}