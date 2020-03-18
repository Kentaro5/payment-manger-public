{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'MailChimp')

@section('content_header')
<h1>MailChimp設定画面</h1>
@stop


@section('content')

<!-- header -->
<section class="content-header">
    <h1>設定項目</h1>
</section>

<!-- body -->
<section class="content">

    <!-- box col-12 -->
    <div class="box box-primary">
        <div class="box-header with-border">
            Simple From
        </div>
        <form action="/i9NH/admin/setting/mailchimp/" method="post" >
            @csrf

            <div class="box-body">
                <div class="form-group">
                    <label>API_KEY</label>
                    <input type="text" name="api_key" class="form-control">
                </div>
                <div class="form-group">
                    <label>リストID</label>
                    <input type="text" name="list_id" class="form-control">
                    {{-- <span class="help-block">パスワードがおかしいです。</span> --}}
                </div>
                <div class="form-group">
                    <label>キャンペーンID</label>
                    <input type="text" name="campaign_id" class="form-control">
                    {{-- <span class="help-block">パスワードがおかしいです。</span> --}}
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
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