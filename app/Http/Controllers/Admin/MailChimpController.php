<?php

namespace App\Http\Controllers\Admin;

use App\MailchimpSetting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Routing\middleware;
use Symfony\Component\Finder\Finder;
use Illuminate\Http\Request;


class MailChimpController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(MailchimpSetting $mailchimp)
    {

        $mailchimp_settings = $mailchimp->get_mailchimp_settings( $mailchimp );

        if( $mailchimp_settings === false ){

            return view('admin.MailChimp.new.form');
        }
        return view('admin.MailChimp.edit.form', compact('mailchimp_settings'));

    }

    public function getMailchimpSettings( $mailchimp ){

        if( $mailchimp->exists ){

            $mailchimp->where('id', $mailchimp->id );

            return $mailchimp = $mailchimp->firstOrFail();
        }

        return false;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'api_key' => 'required',
            'list_id' => 'required',
            'campaign_id' => 'required'
        ]);

        $mailchimp = MailchimpSetting::create([
            'api_key' => request('api_key'),
            'list_id' => request('list_id'),
            'campaign_id' => request('campaign_id'),
        ]);

        return redirect($mailchimp->path());
    }

    public function update(MailchimpSetting $mailchimp)
    {
        $mailchimp->update( request( [ 'api_key', 'list_id', 'campaign_id' ] ) );

        return redirect($mailchimp->path());
    }
}
