<?php

namespace App\Http\Controllers\Admin;

use App\PaypalPlans;
use App\PaypalSetting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Routing\middleware;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Symfony\Component\Finder\Finder;
use Illuminate\Http\Request;


class PayPalListController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(PaypalPlans $paypal)
    {
        $paypal_plan_lists = $paypal->paginate(15);

        return view('admin.paypal.list.table', compact( 'paypal', 'paypal_plan_lists' ));
    }

    public function edit( $paypal_id, PaypalPlans $paypal )
    {

        $paypal_plan = $paypal->get_paypal_plan_by_id( $paypal_id );

        return view('admin.paypal.edit.edit_plan', compact( 'paypal', 'paypal_plan' ));
    }

    public function delete( $paypal_id, PaypalPlans $paypal )
    {
        $paypal_plan = $paypal->get_paypal_plan_by_id( $paypal_id );

        $paypal_plan->delete();

        return redirect($paypal->path());
    }

    public function update( PaypalPlans $paypal )
    {

        $this->validate(request(), [
            'title' => 'required',
            'desc' => 'required',
            'type' => 'required',
            'frequency_interval' => 'required',
            'frequency' => 'required',
            'payment_amount' => 'required',
            'payment_currency' => 'required',
            'payment_state' => 'required',
            'cancel_url' => 'required',
            'return_url' => 'required',
            'max_fail_attempts' => 'required',
            'initial_fail_amount_action' => 'required',
            'auto_bill_amount' => 'required',
        ]);

        //個別のものをアップデートしたい場合はidでアップデートするものを取得する。
        $update_paypal_plan = $paypal->get_paypal_plan_by_id( request('id') );

        $update_paypal_plan->update( request( [
            'title',
            'desc',
            'type',
            'frequency_interval',
            'frequency',
            'payment_amount',
            'payment_currency',
            'payment_state',
            'cancel_url',
            'return_url',
            'max_fail_attempts',
            'initial_fail_amount_action',
            'auto_bill_amount',
        ] ) );

        return redirect($paypal->path());
    }

    public function new(PaypalPlans $paypal)
    {
        return view('admin.paypal.new.add_new_plan', compact( 'paypal' ));
    }

    public function store(Request $request, PaypalSetting $paypal_setting )
    {

        $test = $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'type' => 'required',
            'payment_type' => 'required',
            'frequency_interval' => 'required',
            'frequency' => 'required',
            'payment_amount' => 'required',
            'payment_currency' => 'required',
            'cancel_url' => 'required',
            'return_url' => 'required',
        ]);

        $billing_plan_id = $paypal_setting->get_billing_plan_id( $request );

        $paypal_plan = PaypalPlans::create([
            'title' => request('title'),
            'billing_plan_id' => $billing_plan_id,
            'desc' => request('desc'),
            'type' => request('type'),
            'payment_state' => request('payment_state'),
            'cycles' => request('cycles'),
            'payment_type' => request('payment_type'),
            'frequency_interval' => request('frequency_interval'),
            'frequency' => request('frequency'),
            'payment_amount' => request('payment_amount'),
            'payment_currency' => request('payment_currency'),
            'cancel_url' => request('cancel_url'),
            'return_url' => request('return_url'),
            'max_fail_attempts' => request('max_fail_attempts'),
            'initial_fail_amount_action' => request('initial_fail_amount_action'),
            'auto_bill_amount' => request('auto_bill_amount'),
            'url_pass' => str_random(12)
        ]);

        return redirect($paypal_plan->path());
    }

}
