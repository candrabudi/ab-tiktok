<?php

namespace App\Http\Controllers;

use App\Models\TiktokAccount;
use App\Models\TiktokAccountVideo;
use App\Models\TiktokResult;
use App\Models\TiktokSearch;
use Illuminate\Http\Request;
use Http;

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
        $totalAccount = TiktokAccount::count();
        $totalSearch = TiktokSearch::count();
        $totalResult = TiktokResult::count();
        $totalVideo = TiktokAccountVideo::count();
        return view('home', compact('totalAccount', 'totalSearch', 'totalResult', 'totalVideo'));
    }

}
