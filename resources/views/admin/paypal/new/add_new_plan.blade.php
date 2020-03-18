{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'MailChimp')

@section('content_header')
<h1>PayPalPaln新規作成画面</h1>
@stop


@section('content')

<!-- header -->
<section class="content-header">
    <h1>新規作成項目</h1>
</section>

<!-- body -->
<section class="content">

    <!-- box col-12 -->
    <div class="box box-primary">
        <div class="box-header with-border">
            Simple From
        </div>
        <form action="{{ $paypal->path() }}/new" method="post" >
            @csrf

            <div class="box-body">
                <div class="form-group">
                    <label>商品名</label>
                    <input type="text" name="title" class="form-control" >
                </div>
                <div class="form-group">
                    <label>商品についての説明</label>
                    <textarea name="desc" id="" cols="30" rows="10" class="form-control"></textarea>
                    {{-- <span class="help-block">パスワードがおかしいです。</span> --}}
                </div>

                <div class="form-group">
                    <label>決済の期限について</label>
                    <select name="type">
                        <option value="">決済の期限を選んでください</option>
                        <option value="FIXED">有限</option>
                        <option value="INFINITE">無限</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>決済のタイプ</label>
                    <select name="payment_type">
                        <option value="">決済のタイプを選んでください</option>
                        <option value="TRIAL">お試し</option>
                        <option value="REGULAR">普通決済</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>決済の環境</label>
                    <select name="payment_state">
                        <option value="">決済のタイプを選んでください</option>
                        <option value="SANDBOX">サンドボックス</option>
                        <option value="PRODUCTION">本番環境</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>決済の回数について</label>
                    <select name="frequency_interval">
                        <option value="">決済の間隔を選んでください</option>
                        <option value="0">終了しない</option>
                        @for($i = 1; $i < 13; $i++)
                            <option value="{{ $i }}">{{ $i }}回</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label>決済の間隔について</label>
                    <select name="frequency">
                        <option value="">決済の間隔を選んでください</option>
                        <option value="WEEK">週</option>
                        <option value="DAY">日</option>
                        <option value="MONTH">月</option>
                        <option value="YEAR">年</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>決済のサイクルについて</label>
                    <select name="cycles">
                        <option value="">決済のサイクルを選んでください</option>
                        @for($i = 1; $i < 30; $i++)
                            <option value="{{ $i }}">{{ $i }}回</option>
                        @endfor
                    </select>
                </div>

                <div class="form-group">
                    <label>商品の金額</label>
                    <input type="text" name="payment_amount" class="form-control"  >
                    {{-- <span class="help-block">パスワードがおかしいです。</span> --}}
                </div>

                <div class="form-group">
                    <label>商品の通貨</label>
                    <select name="payment_currency">
                        <option value="">商品の通貨を選んでください</option>
                        <option value="JPY">日本円</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>キャンセルURL</label>
                    <input type="text" name="cancel_url" class="form-control"  >
                </div>

                <div class="form-group">
                    <label>リターンURL</label>
                    <input type="text" name="return_url" class="form-control"  >
                </div>


                <input type="hidden" name="max_fail_attempts" class="form-control" value="0" >
                <input type="hidden" name="initial_fail_amount_action" class="form-control" value="CONTINUE" >
                <input type="hidden" name="auto_bill_amount" class="form-control" value="NO" >

            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">新しく追加</button>
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