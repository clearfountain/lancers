@extends('layouts.auth')
@section('style')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<style>
    .my-hr-line {
        position: relative;
        left: -20px;
        width: calc(100% + 40px);
        border: 1px solid #ddd;
    }
    .hiddeinput {
        color: grey!important;
        background: linear-gradient(to right, #808080, #808080) 5px calc(100% - 5px)/calc(100% - 10px) 2px no-repeat;
        /* <5px calc(100% - 5px)> : position of the gradient [5px from left and 5px from bottom  */
        /* <calc(100% - 10px) 2px> : size of the gradient [width:100%-10px height:2px] */
        background-color: #fcfcfc;
        border: hidden;
        padding: 3px;
    }
    .icon {
        color: grey!important;
        padding: 3px;
    }
    .hiddeselect {
        color: #000!important;
        background: linear-gradient(to right, #000, #000) 5px calc(100% - 5px)/calc(100% - 10px) 2px no-repeat !important;
        /* <5px calc(100% - 5px)> : position of the gradient [5px from left and 5px from bottom  */
        /* <calc(100% - 10px) 2px> : size of the gradient [width:100%-10px height:2px] */
        background-color: #fcfcfc!important;
        border: hidden!important;
        padding: 3px!important;
    }
</style>
@endsection


@section('main-content')

<section class="">
    <div class="container-fluid">
        <h1 style="margin-top: 15px"></h1>


        <div class="">

            <div class="container ">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12  offset-md-2">
                        <div  class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h2 class="pull-left">{{$projects->title}}</h2>
                                </div>
                                <hr>
                                <div class="clearfix"></div>
                                <br/>

                                <hr class="my-hr-line">
                                @foreach($projects->user->estimate as $esti)
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>  <h3>Project Name</h3></label>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="input-group">
                                           
                                                <strong> {{$projects->title}} </strong>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-hr-line">
                                    <div class="">
                                        <label>  <h3>Billing</h3></label>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label">How long (in hours) will it take you to complete this project?</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-group">
                                                <strong> {{$esti->time}} </strong>
                                            </div>
                                        </div>
                                    </div>


                                    <br/>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label">Project starts/ends</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-group">
                                                <i class="icon fa fa-calendar"></i>&nbsp;
                                             
                                                <strong>   {{$esti->start}} </strong>
                                                &nbsp; <i class="icon fa fa-calendar"></i>&nbsp;
                                          
                                                <strong>  {{$esti->end}} </strong>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-hr-line">
                                    <div class="">
                                        <label>  <h3>Expenses</h3></label>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label"> How much would it cost you to power your devices or equipment for this project?</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-group">
                                          
                                                <strong>{{$esti->equipment_cost}}</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label">Are you subcontracting to anyone?</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-group">
                                         
                                                <strong>{{$esti->sub_contractors}}</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label">How much would they be paid?</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-group">
                                        
                                                <strong>{{$esti->sub_contractors_cost}}</strong>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="">
                                        <label>  <h3>Expertise</h3></label>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label"> How many similar projects have you done before?</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-group">
                                                <strong>{{$esti->similar_projects}}</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label">Out of 5 how would you rate your experience level in executing this project?</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-group">
                                                <strong>{{$esti->rating}}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-hr-line">
                                    <div class="">
                                        <label>  <h3>Currency:

                                                <strong>{{$esti->invoice->currency->code}}</strong>
                                            </h3></label>
                                    </div>

                                    <hr class="my-hr-line">
                                      <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>  <h3>Client Name</h3></label>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="input-group">

                                                <strong>{{$projects->client->name}}</strong>
                                            </div>
                                        </div>
                                    </div>
                                
                                    

                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <br/>
                     
                        @endforeach
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>
@endsection


@section('others')
<button class="btn btn-secondary text-white rounded-circle" id="add-something">
    <a href="{{url('estimate/create/step1')}}">    <i class="fas fa-plus"></i> </a>
</button>
@endsection

@section('script')
 
<script>
    let selectStatus = document.querySelector('#select-filter');
    selectStatus.addEventListener('change', function () {
        // this.form.action = "/projects?status="+selectStatus.value;
        // this.form.submit();
        if (selectStatus.value == 'all')
            window.location.href = "/projects";
        else
            window.location.href = "/projects?filter=" + selectStatus.value;
    }, false)
</script>
@endsection