@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Procceed</div>
                <div class="card-body">                   
                    <form method="POST" action="/invoices">
                        @csrf
                        <input type="text" name="estimate_id" value="{{$estimate}}" style="display: none;">

                        <button type="submit" class="btn" style="border: 1px solid gray;
                                 background: #0ABAB5 !important; height: 70px; width: 200px;color:#fff!important">Create Invoice</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
