<?php

namespace App\Http\Controllers\PublicController\MailForm;

use App\PaypalPlans;
use App\PaypalSetting;
use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\ProvisionalEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\MailchimpSetting;


class MailFormController extends Controller
{
    public function index( $plan_password, PaypalPlans $paypal_plan )
    {

        if( empty( $plan_password ) ){
            abort(404);
        }
        if( ! $paypal_plan->is_recored_exists( request( 'plan_password' ) ) ){

            abort(404);
        }

        $plan_data = $paypal_plan->get_paypal_plan_by_password( $plan_password );

        $zeigaku_arr = $this->get_payment_detail($plan_data->payment_amount);

        return view('public.mail_form.mail_form', compact( 'plan_password', 'zeigaku_arr' ));
    }

    public function get_payment_detail( $payment_amount )
    {
        if( !$payment_amount ){
            abort(404);
        }

        $payment_amount = intval($payment_amount);

        $zeinuki_amount = $this->get_zeinuki($payment_amount);
        $only_zeikomi_amount = $this->get_only_zeigaku($payment_amount);

        return [ number_format( $payment_amount ), $zeinuki_amount, $only_zeikomi_amount ];
    }

    public function get_zeinuki( $payment_amount )
    {
        $zeiritsu = 1.08;

        $zeigaku = $payment_amount / $zeiritsu;
        $zeinuki_num = $payment_amount - $zeigaku;

        return number_format( $zeinuki_num );
    }

    public function get_only_zeigaku( $payment_amount )
    {

       $zeiritsu = 1.08;
       $zeigaku = $payment_amount / $zeiritsu;

       return number_format( ceil( $zeigaku ) );
   }

    public function payment( PaypalSetting $paypal_setting )
    {

        $paypal_billing_agreement_url = $paypal_setting->send_user_to_agreement_page( request('billing_plan') );
        parse_str(parse_url($paypal_billing_agreement_url, PHP_URL_QUERY), $query);

        Customer::where('id', intval( request('user_id') ) )
          ->update( [ 'billing_plan_id' => $query['token'] ] );

        return redirect()->away($paypal_billing_agreement_url);
    }

    public function show_payment_page( PaypalPlans $paypal_plan, PaypalSetting $paypal_setting, Customer $customer, Request $request )
    {
        $token = $request->get('token', 1);

        if( empty($token) ){
            abort(404);
        }



        $result = $customer->get_user_data_by_billing_id( $token );

        if( ! $result->exists ){
            dd('error');
        }

        $user_id = $result->id;
        $billing_plan_id = $result->plan_id;

        $plan_data = $paypal_plan->get_paypal_plan_by_billing_plan_id( $billing_plan_id );

        $zeigaku_arr = $this->get_payment_detail($plan_data->payment_amount);

        return view('public.paypal.payment_form', compact( 'billing_plan_id', 'user_id', 'zeigaku_arr' ));
    }


    public function store_first_user_data( MailchimpSetting $mailchimp, PaypalPlans $paypal_plan, PaypalSetting $paypal_setting, Customer $customer )
    {

         request()->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
         ]);

        if( ! $paypal_plan->is_recored_exists( request( 'plan_password' ) ) ){

            dd(request( 'plan_password' ));
        }

        $mailchimp_settings = $mailchimp->get_mailchimp_settings();

        if( $mailchimp_settings === false ){
            return;
        }


        $this->set_mailchimp_list( $mailchimp_settings, request()->all() );

        $plan_data = $paypal_plan->get_paypal_plan_by_password( request()->plan_password );

        $billing_plan_id = $plan_data->billing_plan_id;

        $provisional_customer_info = $customer->create_provisional_customer( request()->all(), $billing_plan_id );

        $result = Customer::create( $provisional_customer_info );


        if( ! $result->exists ){
            dd('error');
        }

        $user_id = $result->id;

        $zeigaku_arr = $this->get_payment_detail($plan_data->payment_amount);

        return view('public.paypal.payment_form', compact( 'billing_plan_id', 'user_id', 'zeigaku_arr' ));
    }

    public function set_mailchimp_list( $mailchimp_settings, $request )
    {

        $mailchimp_api = app('mailchimp');
        $mailchimp_api->set_api_key( $mailchimp_settings->api_key );
        $mailchimp_api->set_list_id( $mailchimp_settings->list_id );

        if( $this->check_user_exits( $request['email'] ) ){
            return true;
        }

        $mailchimp_api->set_list_url( $request['email'] );
        $mailchimp_api->set_register_data( $request['email'], $request['first_name'], $request['last_name'] );

        $result = $mailchimp_api->add_user_to_mailchimp_list();

        $mailchimp_api->set_pre_payment_tag_url();
        $result2 = $mailchimp_api->change_user_tags_to_pre_payment();

        if( $result['http_code'] === 200 && $result2['http_code'] === 200 ){

            return true;
        }

    }

    public function check_user_exits( $user_email='' )
    {
        $mailchimp_api = app('mailchimp');
        $mailchimp_api->set_user_exit_data( $user_email );
        $mailchimp_api->set_check_user_exist_url( $user_email );
        $result = $mailchimp_api->check_user_exits_list( $user_email );

        if( $result['http_code'] === 200 ){

            return true;
        }

        return false;
    }

    public function change_mailchimp_list_tag()
    {
        $mailchimp_api->set_tag_url( $request['email'] );
        $mailchimp_api->set_json_email_data( $request['email'] );
        $result = $mailchimp_api->change_user_payment_status();
    }


}
