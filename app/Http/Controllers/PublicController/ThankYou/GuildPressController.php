<?php

namespace App\Http\Controllers\PublicController\ThankYou;

use App\PaypalSetting;
use App\Customer;
use App\MailchimpSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuildPressController extends Controller
{
    public function index()
    {
        return view('public.thank_you.guildpress.thank');
    }
}

