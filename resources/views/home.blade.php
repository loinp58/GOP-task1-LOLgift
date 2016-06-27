@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">

                @if (session('state'))
                    <div class="alert alert-warning">
                        {{ session('state') }}
                    </div>
                @endif
                    <a href="{{ route('gift.index')}}" class="btn btn-primary">Nhận quà</a> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
