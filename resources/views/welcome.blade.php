@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row text-center">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Nhận quà Liên Minh Huyền Thoại</div>

                <div class="panel panel-body">
                    <div class="col-md-4 col-sm-8 hero-feature">
                        <div class="thumbnail">
                            <img src="http://placehold.it/800x500" alt="">
                            <div class="caption">
                                <h3>Trang phục</h3>
                                <p>
                                    <form action="{{route('gift.store', 1)}}" method="POST">
                                        {{ csrf_field() }}
                                        <button class="btn btn-primary">Nhận</button>
                                    </form> 
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-8 hero-feature">
                        <div class="thumbnail">
                            <img src="http://placehold.it/800x500" alt="">
                            <div class="caption">
                                <h3>IP boost x5</h3>
                                <p>
                                    <form action="{{route('gift.store', 2)}}" method="POST">
                                        {{ csrf_field() }}
                                        <button class="btn btn-primary">Nhận</button>
                                    </form>  
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-8 hero-feature">
                        <div class="thumbnail">
                            <img src="http://placehold.it/800x500" alt="">
                            <div class="caption">
                                <h3>6300 IP</h3>
                                <p>
                                    <form action="{{route('gift.store', 3)}}" method="POST">
                                        {{ csrf_field() }}
                                        <button class="btn btn-primary">Nhận</button>
                                    </form> 
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
