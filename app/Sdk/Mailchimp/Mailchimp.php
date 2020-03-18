<?php

namespace App\Sdk\Mailchimp;

/**
 *
 */
class Mailchimp
{
    protected $tag_url='';
    protected $apiKey='';
    protected $listID='';
    protected $json_email_data = '';
    protected $list_url = '';
    protected $register_data = '';
    protected $pre_payment_tag_id = '';
    protected $pre_payment_tag_url='';
    protected $complete_payment_tag_id = '';
    protected $complete_payment_tag_url='';

    public function set_list_id($listID='')
    {
        $this->listID = $listID;
    }
    public function set_api_key( $apiKey )
    {
        $this->apiKey = $apiKey;
    }

    public function set_tag_url()
    {
        if( $this->apiKey === '' || $this->listID === '' ){
            return;
        }
        $dataCenter = substr($this->apiKey,strpos($this->apiKey,'-')+1);
        $this->tag_url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/'. $this->listID .'/segments/27621/members';
    }

    public function set_list_url($email='')
    {
        if( $email === '' ){
            return;
        }
        $memberID = md5(strtolower($email));
        $dataCenter = substr($this->apiKey,strpos($this->apiKey,'-')+1);
        $this->list_url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $this->listID . '/members/';

    }

    public function set_json_email_data( $email='' )
    {
        if( $email === '' ){
            return;
        }
        $this->json_email_data = json_encode( [ "email_address" => $email]);
    }

    public function set_user_exit_data( $user_email='' )
    {
        if( $user_email === '' ){
            return;
        }
        $this->json_email_data = json_encode( [ "email_address" => $user_email, 'apikey' => $this->apiKey ]);
    }

    public function set_register_data( $email='', $fname='', $lname='' )
    {
        if( $email === '' || $fname === '' || $lname === '' ){
            return;
        }
        $this->register_data = json_encode([
            'email_address' => $email,
            'status'        => 'subscribed',
            'merge_fields'  => [
                'FNAME'     => $fname,
                'LNAME'     => $lname
            ]
        ]);
    }

    public function set_complete_payment_tag_url()
    {

        if( $this->apiKey === '' || $this->listID === '' ){
            return;
        }

        $dataCenter = substr($this->apiKey,strpos($this->apiKey,'-')+1);
        $this->complete_payment_tag_url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/'. $this->listID .'/segments/'.$this->complete_payment_tag_id.'/members';

    }

    public function set_pre_payment_tag_url()
    {

        if( $this->apiKey === '' || $this->listID === '' ){
            return;
        }

        $dataCenter = substr($this->apiKey,strpos($this->apiKey,'-')+1);
        $this->pre_payment_tag_url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/'. $this->listID .'/segments/'.$this->pre_payment_tag_id.'/members';

    }

    public function set_check_user_exist_url( $user_email = '' )
    {
        if( $this->apiKey === '' || $this->listID === '' || $user_email === '' ){
            return;
        }

        $userid = md5($user_email);

        $dataCenter = substr($this->apiKey,strpos($this->apiKey,'-')+1);
        $this->check_user_exit_url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/'. $this->listID .'/members/' . $userid;
    }



    public function add_user_to_mailchimp_list()
    {
        $error_msg = '';
        $curl_request = curl_init($this->list_url);
        curl_setopt($curl_request, CURLOPT_USERPWD, 'user:' . $this->apiKey);
        curl_setopt($curl_request, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_request, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl_request, CURLOPT_POST, 1);
        curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_request, CURLOPT_POSTFIELDS, $this->register_data);
        $result = curl_exec($curl_request);
        $http_code = curl_getinfo($curl_request, CURLINFO_HTTP_CODE);
        if (curl_error($curl_request)) {
            $error_msg = curl_error($curl_request);
        }
        curl_close($curl_request);

        return [ 'http_code' => $http_code, 'result' => $result, 'error' => $error_msg, 'list_url' => $this->list_url ];
    }

    public function change_user_payment_status()
    {
        $curl_request = curl_init($this->tag_url);
        curl_setopt($curl_request, CURLOPT_USERPWD, 'user:' . $this->apiKey);
        curl_setopt($curl_request, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_request, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl_request, CURLOPT_POST, 1);
        curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_request, CURLOPT_POSTFIELDS, $this->json_email_data);
        $result = curl_exec($curl_request);
        $http_code = curl_getinfo($curl_request, CURLINFO_HTTP_CODE);
        if (curl_error($curl_request)) {
            $error_msg = curl_error($curl_request);
        }
        curl_close($curl_request);

        return [ 'http_code' => $http_code, 'result' => $result ];
    }

    public function check_user_exits_list()
    {
        $curl_request = curl_init($this->check_user_exit_url);
        curl_setopt($curl_request, CURLOPT_USERPWD, 'user:' . $this->apiKey);
        curl_setopt($curl_request, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_request, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl_request, CURLOPT_POST, 1);
        curl_setopt($curl_request, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_request, CURLOPT_POSTFIELDS, $this->json_email_data);
        $result = curl_exec($curl_request);
        $http_code = curl_getinfo($curl_request, CURLINFO_HTTP_CODE);
        if (curl_error($curl_request)) {
            $error_msg = curl_error($curl_request);
        }
        curl_close($curl_request);

        return [ 'http_code' => $http_code, 'result' => $result ];
    }

    public function change_user_tags_to_pre_payment()
    {
        $curl_request = curl_init($this->pre_payment_tag_url);
        curl_setopt($curl_request, CURLOPT_USERPWD, 'user:' . $this->apiKey);
        curl_setopt($curl_request, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_request, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl_request, CURLOPT_POST, 1);
        curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_request, CURLOPT_POSTFIELDS, $this->json_email_data);
        $result = curl_exec($curl_request);
        $http_code = curl_getinfo($curl_request, CURLINFO_HTTP_CODE);
        if (curl_error($curl_request)) {
            $error_msg = curl_error($curl_request);
        }
        curl_close($curl_request);

        return [ 'http_code' => $http_code, 'result' => $result ];
    }

    public function change_user_tags_to_complete_payment()
    {
        $curl_request = curl_init($this->complete_payment_tag_url);
        curl_setopt($curl_request, CURLOPT_USERPWD, 'user:' . $this->apiKey);
        curl_setopt($curl_request, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_request, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl_request, CURLOPT_POST, 1);
        curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_request, CURLOPT_POSTFIELDS, $this->json_email_data);
        $result = curl_exec($curl_request);
        $http_code = curl_getinfo($curl_request, CURLINFO_HTTP_CODE);
        if (curl_error($curl_request)) {
            $error_msg = curl_error($curl_request);
        }
        curl_close($curl_request);

        return [ 'http_code' => $http_code, 'result' => $result ];
    }
}