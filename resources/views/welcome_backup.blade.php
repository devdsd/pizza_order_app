@extends('layouts.app')

@section('content')
            <!-- You can create here the vue js components -->
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header"> <h1> Pizza Order App <h1> </div>

                            <div class="card-body">
                                <center>
                                <a class="btn btn-primary btn-bg" href="{{ route('login') }}"> Login </a>
                                <a class="btn btn-primary btn-bg" href="{{ route('register') }}"> Register </a>
                                <center>
                            </div>
                        </div>
                    </div>
                </div>y
            </div>
@endsection
