{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'MailChimp')

@section('content_header')
<h1>PayPal設定画面</h1>
@stop


@section('content')

<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">PayPal決済一覧</h3>
                    <a href="{{ $paypal->path() }}/new" title="">
                        <button type="button" class="btn btn-primary" style="width: 150px;">新規追加</button>
                    </a>
                </div>
                <!-- /.box-header -->

                <div class="box-body">

                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-6">
                            </div>
                            <div class="col-sm-6">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">

                                    @include('admin.paypal.list.thead')
                                    @include('admin.paypal.list.tbody')
                                    @include('admin.paypal.list.tfoot')

                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                {{ $paypal_plan_lists->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</section>
@stop



@section('css')

<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script> console.log('Hi!'); </script>
@stop