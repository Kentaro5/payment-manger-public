{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'MailChimp')

@section('content_header')
<h1>PayPalPaln編集画面</h1>
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
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ $paypal->path() }}/edit/{{ $paypal_plan->id }}" method="post" >
            @csrf

            <div class="box-body">
                <div class="form-group">
                    <label>商品名</label>
                    <input type="text" name="title" class="form-control" value="{{ $paypal_plan->title }}" >
                </div>
                <div class="form-group">
                    <label>商品についての説明</label>
                    <textarea name="desc" id="" cols="30" rows="10" class="form-control">{{ $paypal_plan->desc }}</textarea>
{{--                     <input type="text" name="desc" class="form-control" value="{{ $paypal_plan->desc }}" > --}}
                    {{-- <span class="help-block">パスワードがおかしいです。</span> --}}
                </div>

                <div class="form-group">
                    <label>決済の期限について</label>
                    <select name="type">
                        <option value="">決済の期限を選んでください</option>
                        <option value="FIXED" {{ 'FIXED' == $paypal_plan->type ? 'selected' : ''  }}>有限</option>
                        <option value="INFINITE" {{ 'INFINITE' == $paypal_plan->type ? 'selected' : ''  }}>無限</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>決済のタイプ</label>
                    <select name="payment_type">
                        <option value="">決済のタイプを選んでください</option>
                        <option value="TRIAL" {{ 'TRIAL' == $paypal_plan->payment_type ? 'selected' : ''  }}>お試し</option>
                        <option value="REGULAR" {{ 'REGULAR' == $paypal_plan->payment_type ? 'selected' : ''  }}>普通決済</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>決済の環境</label>
                    <select name="payment_state">
                        <option value="">決済のタイプを選んでください</option>
                        <option value="SANDBOX" {{ 'SANDBOX' == $paypal_plan->payment_state ? 'selected' : ''  }}>サンドボックス</option>
                        <option value="PRODUCTION" {{ 'PRODUCTION' == $paypal_plan->payment_state ? 'selected' : ''  }}>本番環境</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>決済の回数について</label>
                    <select name="frequency_interval">
                        <option value="">決済の間隔を選んでください</option>
                        <option value="0" {{ 0 == $paypal_plan->frequency_interval ? 'selected' : ''  }}>終了しない</option>
                        @for($i = 1; $i < 13; $i++)
                            <option value="{{ $i }}" {{ $i == $paypal_plan->frequency_interval ? 'selected' : ''  }}>{{ $i }}回</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label>決済の間隔について</label>
                    <select name="frequency">
                        <option value="">決済の間隔を選んでください</option>
                        <option value="WEEK" {{ 'WEEK' == $paypal_plan->frequency ? 'selected' : ''  }}>週</option>
                        <option value="DAY" {{ 'DAY' == $paypal_plan->frequency ? 'selected' : ''  }}>日</option>
                        <option value="MONTH" {{ 'MONTH' == $paypal_plan->frequency ? 'selected' : ''  }}>月</option>
                        <option value="YEAR" {{ 'YEAR' == $paypal_plan->frequency ? 'selected' : ''  }}>年</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>決済のサイクルについて</label>
                    <select name="cycles">
                        <option value="">決済のサイクルを選んでください</option>
                        @for($i = 1; $i < 30; $i++)
                            <option value="{{ $i }}" {{ $i == $paypal_plan->cycles ? 'selected' : ''  }}>{{ $i }}回</option>
                        @endfor
                    </select>
                </div>

                <div class="form-group">
                    <label>商品の金額</label>
                    <input type="text" name="payment_amount" class="form-control" value="{{ $paypal_plan->payment_amount }}" >
                    {{-- <span class="help-block">パスワードがおかしいです。</span> --}}
                </div>

                <div class="form-group">
                    <label>商品の通貨</label>
                    <select name="payment_currency">
                        <option value="">商品の通貨を選んでください</option>
                        <option value="JPY" {{ 'JPY' == $paypal_plan->payment_currency ? 'selected' : ''  }}>日本円</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>キャンセルURL</label>
                    <input type="text" name="cancel_url" class="form-control" value="{{ $paypal_plan->cancel_url }}" >
                </div>

                <div class="form-group">
                    <label>リターンURL</label>
                    <input type="text" name="return_url" class="form-control" value="{{ $paypal_plan->return_url }}" >
                </div>


                <input type="hidden" name="max_fail_attempts" class="form-control" value="0" >
                <input type="hidden" name="initial_fail_amount_action" class="form-control" value="CONTINUE" >
                <input type="hidden" name="auto_bill_amount" class="form-control" value="NO" >

            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">更新</button>
                <input type="hidden" name="id" class="form-control" value="{{ $paypal_plan->id }}" >
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