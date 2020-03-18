{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'MailChimp')

@section('content_header')
<h1>PayPal設定画面</h1>
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
        <form action="/i9NH/admin/setting/paypal/{{ $paypal_settings->id }}" method="post" >
            @csrf

            <div class="box-body">
                <div class="form-group">
                    <label>クライアント_ID</label>
                    <input type="text" name="crient_id" class="form-control" value="{{ $paypal_settings->crient_id }}" >
                </div>
                <div class="form-group">
                    <label>シークレット_ID</label>
                    <input type="text" name="secret_id" class="form-control"  value="{{ $paypal_settings->secret_id }}" >
                    {{-- <span class="help-block">パスワードがおかしいです。</span> --}}
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">更新</button>
                <input type="hidden" name="id" class="form-control"  >
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