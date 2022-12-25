<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function welcome()
    {
        return Inertia::render('welcome', [
            'videos' => Video::all(),
        ]);
    }
}
