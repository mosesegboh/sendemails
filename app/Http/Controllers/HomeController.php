<?php

namespace App\Http\Controllers;

use App\Models\CustomerGroup;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $groups = CustomerGroup::paginate(10);
        return view('home', ['groups' => $groups]);
    }
}
