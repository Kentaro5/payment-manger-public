<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name='robots' content='noindex,nofollow' />

    <!-- CSRF Token -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-90349004-4"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-90349004-4');
    </script>


    <title>GuildPress販売ページ</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <style>
        .payment-body p{
            line-height: 1.2;
            font-size:20px;
            margin-bottom: 0px;
        }

        .payment-body p span{
            font-size: 12px;
        }
        .gray-box{
            background: #f9f9f9;
            color: #999;
        }
        .white-box{
            background: #fff;
            color: #999;
        }

        .border-orange{
            border-bottom: 2px solid #DDA24A;
        }
        .white-box.white-box-last{

            padding-top: 32px;
            padding-bottom: 32px;
        }
        .gray-box, .white-box{
            padding: 16px 8px;
        }

        .paymnet-box{
            width: 600px;
            margin: 0 auto;
            background: #fff;
             box-shadow: 0 0 11px rgba(33,33,33,.2);
             margin-bottom: 80px;
        }

        .payment-header{
            background-color: #225db5;
        }

        .inner-box{
            padding: 32px 16px;

        }

        .inner-box h2,.inner-box p{
            color: #fff;
        }
        .inner-box h2{
            margin-bottom: 0px;
            font-weight: bold;
        }

        .inner-box p{
            margin-bottom: 0px;
            font-weight: bold;
        }

        .payment-btn{
            background-color: #DDA24A;
            width: 360px;
            font-size: 30px;
            border: none;
            color:#fff;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            -o-transition: all 0.218s;
            -moz-transition: all 0.218s;
            -webkit-transition: all 0.218s;
            transition: all 0.218s;
        }

        .register-btn{
            width: 100%;
            background-color: #DDA24A;
            border: 1px solid #DDA24A;
            font-size: 24px;
            border: none;
            color:#fff;
            margin-top: 16px;
            margin-bottom: 16px;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            -o-transition: all 0.218s;
            -moz-transition: all 0.218s;
            -webkit-transition: all 0.218s;
            transition: all 0.218s;
        }

        .register-btn:hover,.payment-btn:hover{
            color:#DDA24A;
            background-color: #fff;
            border: 1px solid #DDA24A;
        }

    </style>
</head>
<body>
    @yield('content')
</body>
</html>