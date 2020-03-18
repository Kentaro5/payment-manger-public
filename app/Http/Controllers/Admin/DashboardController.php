<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Routing\middleware;
use Symfony\Component\Finder\Finder;


class DashboardController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $paypalq_api = app('paypal');
    	$test = ['test', 'test2'];

    	return view('admin.dashboard', compact('test'));
    }
}
