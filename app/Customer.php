<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = ['billing_plan_id', 'first_name', 'last_name', 'email', 'payment_state', 'admin_id', 'plan_id'];
    public function create_provisional_customer( $request, $billing_plan_id )
    {
        $regsiter_customer_info = [
            'billing_plan_id' => $billing_plan_id,
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'registered_date' => Carbon::now()->toDateTimeString(),
            'payment_state' => 'provisional',
            'admin_id' => 1,
            'plan_id' => $billing_plan_id,
        ];

        return $regsiter_customer_info;
    }

    public function get_user_data_by_billing_id( $billing_plan_id )
    {

        return $this->where( 'billing_plan_id', $billing_plan_id )->first();
    }

    public function update_user_data_by_id( $customer_id, $update_data )
    {
        return $this->where( 'id', $customer_id )->update( $update_data );
    }
}
