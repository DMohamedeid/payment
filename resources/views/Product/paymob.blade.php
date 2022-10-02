<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel </title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha256-YLGeXaapI0/5IgZopewRJcFXomhRMlYYjugPLSyNjTY=" crossorigin="anonymous" />

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }
        .content {
            margin-top: 100px;
            text-align: center;
        }
    </style>
</head>
<body>


<div class="container">
    <div class="row justify-content-center">
        @if ($message = \Session::get('success'))
            <div class="custom-alerts alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                {!! $message !!}
            </div>
            <?php \Session::forget('success');?>
        @endif

        @if ($message = \Session::get('error'))
            <div class="custom-alerts alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                {!! $message !!}
            </div>
            <?php \Session::forget('error');?>
        @endif
        <h2 style="text-align: center"> Checkout Form</h2>
        <div class="col-md-12">
            <div style="text-align: center" class="row">
                <div class="col-sm-md-5">
                    <div class="content ">
                        <h1>Card</h1>
                        <a href="{{route('credit' , ['type' => 'card'])}}">
                            <img src="{{asset('images/paymob/Untitled.pngpaymobcard.png')}}">
                        </a>
                    </div>
                    {{--                                    <form action="{{route('credit')}}" method="POST">--}}
                    {{--                                        {{ csrf_field() }}--}}
                    {{--                                        <input style="width: fit-content" type="submit" value="Paymob" class="btn">--}}
                    {{--                                    </form>--}}
                </div>
                <div class="col-sm-md-5">
                    <div class="content">
                        <h1>Card</h1>
                        <a href="{{route('credit' , ['type' => 'mobileWallet'])}}">
                            <img src="{{asset('images/paymob/mobile wallet.png')}}">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
