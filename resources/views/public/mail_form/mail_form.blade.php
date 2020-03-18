@extends('layouts.public.index')

@section('content')
<div class="container form_box">
    <h1 class="title center">GuildPress購入フォーム</h1>
    <div class="paymnet-box">
        <div class="payment-header center">
            <div class="inner-box border-orange">
                <h2>GuildPress</h2>
                <p>{{ $zeigaku_arr[0] }}円(税込み)/年(年額払い)</p>
            </div>
        </div>
        <div class="payment-body border-orange">
            <div class="mailform">
                <form action="/guildpress/mail" method="post" >
                    @csrf

                    <div class="form-group">

                        <label for="exampleInputPassword1">姓</label><br/>
                        @if ($errors->has('first_name'))
                            <span class="text-danger">姓は必須入力項目です。</span>
                        @endif
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" id="exampleInputPassword1" placeholder="例）山田">
                    </div>
                    <div class="form-group">

                        <label for="exampleInputPassword1">名</label><br/>
                        @if ($errors->has('last_name'))
                            <span class="text-danger">名は必須入力項目です。</span>
                        @endif
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" id="exampleInputPassword1" placeholder="例）太郎">
                    </div>

                    <div class="form-group">

                        <label for="exampleInputEmail1">メールアドレス</label><br/>
                        @if ($errors->has('email'))
                            <span class="text-danger">メールアドレスは必須入力項目です。</span>
                        @endif
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" value="{{ old('email') }}" aria-describedby="emailHelp" placeholder="example@example.com">
                    </div>
                    <p class="white-box"><span>商品の購入をされた時点で、利用規約に同意したものとみなします。<br/><a href="https://geeksgrowth.com/commercial-transaction-law/" target="_blank">利用規約についてはこちら</a></span></p>

                    <button type="submit" class="register-btn">登録</button>
                    <input type="hidden" name="plan_password" value="{{ $plan_password }}">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
