<?php

namespace App\Http\Controllers\PublicController;

use App\PaypalPlans;
use App\PaypalSetting;
use App\Customer;
use App\MailchimpSetting;
use App\Mail\ProvisionalEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Notifications\SlackNotification;


class PayPalApiController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index( PaypalSetting $paypal_setting, MailchimpSetting $mailchimp, PaypalPlans $paypal_plan )
    {

        $customer = new Customer();

        $payment_token = request( 'token' );


        //ここが１で固定になっているので、後で変更する。　
        $user_data = $customer->get_user_data_by_billing_id( $payment_token, $payment_token );

        $paypal_data = $paypal_plan->get_paypal_plan_by_billing_plan_id( $user_data->plan_id );

        $payment_data = $paypal_setting->create_payment( $payment_token, $paypal_data->payment_state );

        $update_data = [
            'billing_plan_id' => $payment_data['id'],
            'payment_state' => $payment_data['state']
        ];

        $customer->update_user_data_by_id( $user_data->id, $update_data );

        $this->set_mailchimp_complete_tag( $mailchimp, $user_data );

        $user = new User();
        $user->notify(new SlackNotification('決済が完了しました。', $user_data->email, $user_data->updated_at ));

        //$this->send_thank_you_email($user_data);

        return redirect('/guildpress/thank-you');
    }

    public function send_thank_you_email( $user_data )
    {
        Mail::to($user_data->email)
            ->send(new ProvisionalEmail('test'));
    }

    public function set_mailchimp_complete_tag( $mailchimp, $user_data )
    {

        $mailchimp_settings = $mailchimp->get_mailchimp_settings();
        $mailchimp_api = app('mailchimp');
        $mailchimp_api->set_api_key( $mailchimp_settings->api_key );
        $mailchimp_api->set_list_id( $mailchimp_settings->list_id );

        $mailchimp_api->set_json_email_data( $user_data->email );

        $mailchimp_api->set_complete_payment_tag_url();
        $result2 = $mailchimp_api->change_user_tags_to_complete_payment();
    }

    public function test()
    {
        $user = new User();
        $user->notify(new SlackNotification('メールテスト','test@exaple.com'));
    }
}
