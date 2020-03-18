<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class MailchimpSetting extends Model
{
    protected $table = 'mailchimp_settings';
    protected $fillable = ['api_key', 'list_id', 'campaign_id'];
    public $timestamps = false;

    public function path()
    {
        return "/i9NH/admin/setting/mailchimp/";
    }

    public function get_mailchimp_settings(){

        try {
            $mailchimp_setting = $this->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }

        return $mailchimp_setting;
    }
}
