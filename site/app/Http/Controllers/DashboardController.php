<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Models;

class DashboardController extends Controller
{
    public function index()
    {
        $models = Models::get();
        return view('dashboard', compact('models'));
    }
}
