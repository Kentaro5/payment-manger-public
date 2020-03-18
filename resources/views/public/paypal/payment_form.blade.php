@extends('layouts.public.index')

@section('content')
<div class="container form_box">
    <h1 class="title center">GuildPress購入フォーム</h1>
    <div class="paymnet-box">

        <div class="center">
            <div class="payment-header">
                <div class="inner-box border-orange">
                    <h2>GuildPress</h2>
                    <p>{{ $zeigaku_arr[0] }}円(税込み)/年(年額払い)</p>
                </div>
            </div>
            <div class="payment-body">

                <p class="white-box"><span>商品名<br/></span>GuildPress</p>

                {{-- <p class="white-box"><span>動作環境<br/></span>PHP7以上<br/>WordPress4.9以上</p> --}}
                <p class="gray-box"><span>金額<br/></span>{{ $zeigaku_arr[2] }}円</p>
                <p class="white-box"><span>消費税<br/></span>{{ $zeigaku_arr[1] }}円</p>
                <p class="gray-box"><span>合計金額<br/></span>{{ $zeigaku_arr[0] }}円</p>

                {{-- <p class="white-box"><span>利用規約について<br/></span>商品の購入をされた時点で、利用規約に同意したものとみなします。<br/>
                    <a href="https://geeksgrowth.com/commercial-transaction-law/" target="_blank">利用規約についてはこちら</a></p>
                    <p class="gray-box"><span>決済手段<br/></span>PayPal</p> --}}
                    <form class="white-box white-box-last border-orange" action="/guildpress/payment" method="post" >
                        @csrf
                        <button type="submit" class="btn payment-btn" >PayPalで支払う</button>
                        <input type="hidden" name="billing_plan" value="{{ $billing_plan_id }}">
                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                    </form>
            </div>

        </div>
    </div>
</div>
@endsection
