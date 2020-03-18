<?php

namespace App;

use App\PaypalPlans;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaypalSetting extends Model
{
    protected $table = 'paypal_settings';
    protected $fillable = ['crient_id', 'secret_id'];
    public $timestamps = false;

    public function path()
    {
        return "/i9NH/admin/setting/paypal/";
    }

    public function get_pay_pal_settings(){

        try {
            $paypla_setting = $this->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }

        return $paypla_setting;

    }

    public function get_billing_plan_id( $request )
    {

        $paypal_api = app('paypal');

        $this->set_access_token( $paypal_api, $request->payment_state );

        $paypal_api->reset_agreement_data();
        $paypal_api->reset_billing_plan_data();

        $paypal_api->set_billing_plan_data( $request );

        $paypal_api->create_billing_plan();

        $billing_plan_id = $paypal_api->get_billing_plan_id();

        $paypal_api->activate_billing_plan( $billing_plan_id );

        return $billing_plan_id;
    }

    public function set_access_token( $paypal_api, $payment_state )
    {
        $paypal_settings = $this->get_pay_pal_settings();
        $paypal_api->set_api_url( $payment_state );
        $paypal_api->set_api_info( $paypal_settings );
        $paypal_api->send_access_token_request();
    }

    public function send_user_to_agreement_page( $billing_plan )
    {

        $paypal_plans = new PaypalPlans();

        //ここが１で固定になっているので、後で変更する。　
        $paypal_plan_data = $paypal_plans->get_paypal_plan_by_billing_plan_id($billing_plan);

        $paypal_api = app('paypal');

        $paypal_api->reset_agreement_data();
        $paypal_api->reset_billing_plan_data();

        $this->set_access_token( $paypal_api, $paypal_plan_data->payment_state );

        $paypal_api->set_agreement_time_data();
        $paypal_api->set_agreement_data( $paypal_plan_data, $billing_plan );
        $paypal_api->set_billing_plan_data($paypal_plan_data);

        $redirect_url = $paypal_api->send_user_to_billing_agreement_page();

        return $redirect_url;

    }

    public function create_payment( $agreement_token_id, $payment_state )
    {
        $paypal_api = app('paypal');
        $this->set_access_token( $paypal_api, $payment_state );
        $paypal_api->reset_agreement_data();
        $paypal_api->reset_billing_plan_data();
        return $paypal_api->create_payment( $agreement_token_id );
    }


}
