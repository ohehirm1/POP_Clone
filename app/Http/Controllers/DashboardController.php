<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('dashboard')->with([
            'participants' => auther()->participants->sortByDesc('created_at')->take(10),
            'businesses' => auther()->businesses->sortByDesc('created_at')->take(10),
            'allocations' => auther()->allocations->sortByDesc('created_at')->take(10),
        ]);
    }
}
