<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class RulesController extends Controller
{
    /**
     * Display the rules and guidelines page.
     */
    public function index(): View
    {
        return view('rules.index');
    }
} 