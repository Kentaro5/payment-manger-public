<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaypalPlans extends Model
{
    protected $table = 'paypal_plans';
    protected $fillable = ['title', 'billing_plan_id', 'cycles', 'payment_state', 'payment_type', 'desc','type','frequency_interval','frequency','payment_amount','payment_currency','cancel_url','return_url','max_fail_attempts','initial_fail_amount_action','auto_bill_amount','url_pass'];

    public $timestamps = false;

    public function path()
    {
        return "/i9NH/admin/paypal/list";
    }

    public function get_paypal_plan_by_id( $id ){

        if( empty( $id ) ){
            $id = $this->id;
        }

        return $this->findOrFail($id);
    }

    public function get_paypal_plan_by_password( $plan_password ){

        if( empty( $plan_password ) ){
            $plan_password = $this->url_pass;
        }

        return $this->where( 'url_pass', $plan_password )->first();
    }

    public function get_paypal_plan_by_billing_plan_id( $billing_plan_id ){

        if( empty( $billing_plan_id ) ){
            $billing_plan_id = $this->billing_plan_id;
        }

        return $this->where( 'billing_plan_id', $billing_plan_id )->first();
    }

    public function is_recored_exists($plan_password)
      {

          return $this->where( 'url_pass', $plan_password )->exists();
      }


}
