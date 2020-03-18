{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'MailChimp')

@section('content_header')
<h1>MailChimp設定編集画面</h1>
@stop


@section('content')

<!-- header -->
<section class="content-header">
    <h1>編集項目</h1>
</section>

<!-- body -->
<section class="content">

    <!-- box col-12 -->
    <div class="box box-primary">
        <div class="box-header with-border">
            Simple From
        </div>
        <form action="/i9NH/admin/setting/mailchimp/{{ $mailchimp_settings->id }}" method="post" >
            @csrf

            <div class="box-body">
                <div class="form-group">
                    <label>API_KEY</label>
                    <input type="text" name="api_key" class="form-control" value="{{ $mailchimp_settings->api_key }}">
                </div>
                <div class="form-group">
                    <label>リストID</label>
                    <input type="text" name="list_id" class="form-control" value="{{ $mailchimp_settings->list_id }}" >
                    {{-- <span class="help-block">パスワードがおかしいです。</span> --}}
                </div>
                <div class="form-group">
                    <label>キャンペーンID</label>
                    <input type="text" name="campaign_id" class="form-control" value="{{ $mailchimp_settings->campaign_id }}" >
                    {{-- <span class="help-block">パスワードがおかしいです。</span> --}}
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <input type="hidden" name="id" class="form-control" value="{{ $mailchimp_settings->id }}" >
            </div>
        </form>
    </div>
</section>

@stop



@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script> console.log('Hi!'); </script>
@stop