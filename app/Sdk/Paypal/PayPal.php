<?php

namespace App\Sdk\Paypal;

/**
 *
 */
class PayPal
{
    protected $secret='';
    protected $clientId='';
    protected $access_token='';
    protected $billing_plans = array();
    protected $agreement_data = array();
    protected $billing_plan_id;
    protected $access_token_url = '';
    protected $billing_plans_url = '';
    protected $billing_agreements_url = '';

    public function set_api_url( $payment_state )
    {
        switch ($payment_state) {

            case 'SANDBOX':
                $this->set_sandbox_url();
                break;

            case 'PRODUCTION':
                $this->set_payment_url();
                break;

            default:
                dd('不正なアクセスです。');
                break;
        }
    }

    public function set_sandbox_url()
    {
        $this->access_token_url = 'https://api.sandbox.paypal.com/v1/oauth2/token';
        $this->billing_plans_url = 'https://api.sandbox.paypal.com/v1/payments/billing-plans/';
        $this->billing_agreements_url = 'https://api.sandbox.paypal.com/v1/payments/billing-agreements/';
    }

    public function set_payment_url()
    {
        $this->access_token_url = 'https://api.paypal.com/v1/oauth2/token';
        $this->billing_plans_url = 'https://api.paypal.com/v1/payments/billing-plans/';
        $this->billing_agreements_url = 'https://api.paypal.com/v1/payments/billing-agreements/';
    }

    public function set_api_info( $paypal_settings )
    {

        $this->secret = $paypal_settings->secret_id;
        $this->clientId = $paypal_settings->crient_id;
    }

    public function get_agreement()
    {
        $empty_data = array();
        $empty_data = json_encode($empty_data);

        $curl_request = curl_init();
        curl_setopt($curl_request, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl_request, CURLOPT_URL, $this->billing_agreements_url);
        curl_setopt($curl_request, CURLOPT_HTTPHEADER , array( "Content-Type: application/json", "Authorization: Bearer ".$this->access_token ) );
        $plan_result = curl_exec($curl_request);

        $json_result = $this->check_result( $plan_result );

        curl_close($curl_request);
    }

    public function send_access_token_request()
    {
        $curl_request = curl_init();

        curl_setopt( $curl_request, CURLOPT_URL, $this->access_token_url );
        curl_setopt( $curl_request, CURLOPT_HEADER, false);
        curl_setopt( $curl_request, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt( $curl_request, CURLOPT_SSLVERSION , 6);
        curl_setopt( $curl_request, CURLOPT_POST, true);
        curl_setopt( $curl_request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt( $curl_request, CURLOPT_USERPWD, $this->clientId.":".$this->secret);
        curl_setopt( $curl_request, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

        $curl_result = curl_exec($curl_request);

        $json_result = $this->check_result( $curl_result );

        $this->set_access_token( $json_result['access_token'] );

        curl_close($curl_request);

    }

    public function activate_billing_plan( $billing_plan_id )
    {

        $curl_request = curl_init();

        $activate_data = '[
        {
            "op": "replace",
            "path": "/",
            "value": {
                "state": "ACTIVE"
                }
            }
        ]';

        curl_setopt($curl_request, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($curl_request, CURLOPT_URL, $this->billing_plans_url.$billing_plan_id."/");
        curl_setopt($curl_request, CURLOPT_HTTPHEADER , array( "Content-Type: application/json", "Authorization: Bearer ".$this->access_token ) );
        curl_setopt($curl_request, CURLOPT_POSTFIELDS, $activate_data);

        $activate_result = curl_exec($curl_request);

        $json_result = $this->check_result( $activate_result );

        curl_close($curl_request);

    }

    public function set_agreement_time_data()
    {
        $timestamp = strtotime("+1hour");
        $startDate = date('c', $timestamp);
        $startDate = substr($startDate, 0, strcspn($startDate,'+'));
        $this->start_date = $startDate."Z";
    }

    public function set_agreement_data( $paypal_settings, $billing_plan_id )
    {

        $this->agreement_data['name'] = $paypal_settings->title;
        $this->agreement_data['description'] = $paypal_settings->desc;
        $this->agreement_data['start_date'] = $this->start_date;
        $this->agreement_data['plan'] = array();
        $this->agreement_data['plan']['id'] = $billing_plan_id;
        $this->agreement_data['payer'] = array();
        $this->agreement_data['payer']['payment_method'] = "paypal";

        $this->agreement_data['shipping_address'] = array();
        $this->agreement_data['shipping_address']['line1'] = '-';
        $this->agreement_data['shipping_address']['line2'] = '-';
        $this->agreement_data['shipping_address']['city'] = '-';
        $this->agreement_data['shipping_address']['state'] = '-';
        $this->agreement_data['shipping_address']['postal_code'] = '000-0000';
        $this->agreement_data['shipping_address']['country_code'] = 'JP';

        $this->agreement_data['override_merchant_preferences']['return_url'] = $paypal_settings->return_url;
        $this->agreement_data['override_merchant_preferences']['cancel_url'] = $paypal_settings->cancel_url;

    }

    public function create_payment( $agreement_token_id )
    {

        $curl_request = curl_init();
        curl_setopt($curl_request, CURLOPT_URL, $this->billing_agreements_url.$agreement_token_id."/agreement-execute");
        curl_setopt($curl_request, CURLOPT_VERBOSE, 1);
        curl_setopt($curl_request, CURLOPT_HEADER, 0);
        curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl_request, CURLOPT_HTTPHEADER , array( "Content-Type: application/json", "Authorization: Bearer ".$this->access_token ) );
        curl_setopt($curl_request, CURLOPT_POST, 1);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);

        $plan_result = curl_exec($curl_request);
        $json_result = $this->check_result( $plan_result );

        curl_close($curl_request);

        return $json_result;

    }

    public function send_user_to_billing_agreement_page()
    {

        $agreement_json = json_encode($this->agreement_data);

        $curl_request = curl_init();

        curl_setopt($curl_request, CURLOPT_POST, 1);
        curl_setopt($curl_request, CURLOPT_URL, $this->billing_agreements_url );
        curl_setopt($curl_request, CURLOPT_HTTPHEADER , array( "Content-Type: application/json", "Authorization: Bearer ".$this->access_token ) );
        curl_setopt($curl_request, CURLOPT_POSTFIELDS, $agreement_json);

        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);

        $approve_result = curl_exec($curl_request);
        $json_result = $this->check_result( $approve_result );
        curl_close($curl_request);
        $redirect_url = $json_result['links'][0]['href'];
        return $redirect_url;
    }

    public function set_access_token( $access_token )
    {
        $this->access_token = $access_token;
    }

    public function check_result( $result )
    {
        if( empty( $result ) ){

            dd("Error: No response.");
        }else{

            $json = json_decode($result, TRUE);
        }

        return $json;
    }
    public function create_billing_plan()
    {
        $curl_request = curl_init();

        $send_billing_plan_data = json_encode( $this->get_billing_plan_data() );


        curl_setopt( $curl_request, CURLOPT_URL, $this->billing_plans_url );
        curl_setopt( $curl_request, CURLOPT_VERBOSE, 1);
        curl_setopt( $curl_request, CURLOPT_HEADER, 0);
        curl_setopt( $curl_request, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt( $curl_request, CURLOPT_HTTPHEADER , array( "Content-Type: application/json", "Authorization: Bearer ".$this->access_token ) );
        curl_setopt( $curl_request, CURLOPT_POST, 1);
        curl_setopt( $curl_request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt( $curl_request, CURLOPT_POSTFIELDS, $send_billing_plan_data);

        $plan_result = curl_exec($curl_request);

        $plan_json = $this->check_result( $plan_result );

        curl_close($curl_request);

        if( !isset($plan_json['id']) ){

            dd($plan_json);
        }
        $this->set_billing_plan_id( $plan_json['id'] );
    }

    public function get_billing_plan_id()
    {
        return $this->billing_plan_id;
    }

    public function set_billing_plan_id( $billing_plan_id )
    {
        $this->billing_plan_id = $billing_plan_id;
    }

    public function get_billing_plan_data()
    {

        return $this->billing_plans;
    }

    public function set_billing_plan_data( $billing_plan_data )
    {

        $this->billing_plans['name'] = $billing_plan_data->title;
        $this->billing_plans['description'] = $billing_plan_data->desc;
        $this->billing_plans['type'] = $billing_plan_data->type;

        $this->billing_plans['payment_definitions'] = array();
        $this->billing_plans['payment_definitions'][0] = array();
        $this->billing_plans['payment_definitions'][0]['name'] = $billing_plan_data->title;
        $this->billing_plans['payment_definitions'][0]['type'] = $billing_plan_data->payment_type;
        $this->billing_plans['payment_definitions'][0]['frequency'] = $billing_plan_data->frequency;
        $this->billing_plans['payment_definitions'][0]['frequency_interval'] = $billing_plan_data->cycles;
        $this->billing_plans['payment_definitions'][0]['amount'] = array();
        $this->billing_plans['payment_definitions'][0]['amount']['value'] = $billing_plan_data->payment_amount;
        $this->billing_plans['payment_definitions'][0]['amount']['currency'] = $billing_plan_data->payment_currency;
        $this->billing_plans['payment_definitions'][0]['cycles'] = $billing_plan_data->frequency_interval;

        $this->billing_plans['payment_definitions'][0]['charge_models'] = array();

        $this->billing_plans['merchant_preferences'] = array();
        $this->billing_plans['merchant_preferences']['cancel_url']  = $billing_plan_data->cancel_url;
        $this->billing_plans['merchant_preferences']['return_url']  = $billing_plan_data->return_url;
        $this->billing_plans['merchant_preferences']['max_fail_attempts']  = $billing_plan_data->max_fail_attempts;
        $this->billing_plans['merchant_preferences']['initial_fail_amount_action']  = $billing_plan_data->initial_fail_amount_action;
        $this->billing_plans['merchant_preferences']['auto_bill_amount']  = $billing_plan_data->auto_bill_amount;

    }

    public function reset_billing_plan_data()
    {
        $this->billing_plans = array();
    }

    public function reset_agreement_data()
    {
        $this->agreement_data = array();
    }
}