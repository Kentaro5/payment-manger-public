<?php

namespace App\Http\Controllers\Admin;

use App\PaypalSetting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Routing\middleware;
use Symfony\Component\Finder\Finder;
use Illuminate\Http\Request;


class PayPalController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(PaypalSetting $paypal)
    {

        $paypal_settings = $paypal->get_pay_pal_settings();

        if( $paypal_settings === false ){

            return view('admin.paypal.new.form');
        }

        return view('admin.paypal.edit.form', compact( 'paypal_settings' ));

    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'crient_id' => 'required',
            'secret_id' => 'required',
        ]);

        $paypal = PaypalSetting::create([
            'crient_id' => request('crient_id'),
            'secret_id' => request('secret_id'),
        ]);

        return redirect($paypal->path());
    }

    public function update(PaypalSetting $paypal)
    {
        $paypal->update( request( [ 'crient_id', 'secret_id' ] ) );

        return redirect($paypal->path());
    }

}
