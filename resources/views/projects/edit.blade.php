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
                                <div class="clearrfix"></div>
                                <br/>

                                <hr class="my-hr-line">
                                @foreach($projects->user->estimate as $esti)
                                <form method="post" action="{{url('edit-project-save',['id'=>$esti->id])}}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>  <h3>Project Name</h3></label>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="input-group">
                                                <input type="text" class="form-control col-md-6 col-sm-10" required name="title" value="{{$projects->title}}" placeholder="Title" />
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
                                                <input type="number" class="form-control col-md-4 col-sm-10" required name="time" value="{{$esti->time}}" placeholder="Hours" />
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
                                                <input class="hiddeinput col-md-4 col-sm-3" type="text" required onfocus="(this.type = 'date'); (this.name = 'start')" name="start" value="{{$esti->start}}" placeholder=" Set start date" />
                                                &nbsp; <i class="icon fa fa-calendar"></i>&nbsp;
                                                <input type="text" class="hiddeinput col-md-4 col-sm-3"  required onfocus="(this.type = 'date'); (this.name = 'end')" name="end" value="{{$esti->end}}" placeholder="Set end date" />
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
                                                <input type="number" class="form-control col-md-4 col-sm-10" required name="equipment_cost"  value="{{$esti->equipment_cost}}" id="est1" placeholder="NGN 0.00" />
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
                                                <input type="text"  class="form-control col-md-6 col-sm-10" required name="sub_contractors" value="{{$esti->sub_contractors}}" id="est2" placeholder="E.g. Illustrator, Consulting..." />
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
                                                <input type="number" class="form-control col-md-4 col-sm-10" required name="sub_contractors_cost" value="{{$esti->sub_contractors_cost}}" id="est3" placeholder="NGN 0.00" />
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
                                                <input type="number" class="form-control col-md-4 col-sm-10" required name="similar_projects" value="{{$esti->similar_projects}}" id="exp1">
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
                                                <input class="form-control col-md-6 col-sm-10" type="number" required name="rating" value="{{$esti->rating}}" id="exp2"> /5
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-hr-line">
                                    <div class="">
                                        <label>  <h3>Currency:

                                                <select class="hiddeselect" name="currency_id" required>
                                                    <option value="">Select Currency</option>
                                                    @foreach($currencies as $currency)
                                                    <option value="{{$currency->id}}" {{$esti->currency_id == $currency->id ? 'selected' : '' }}>{{$currency->code}}</option>
                                                    @endforeach
                                                </select>

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


                                                <select name="client" class="form-control form-control col-md-6 col-sm-10" style="color: #919191">
                                                    <option value="new" selected>Select Client</option>
                                                    @foreach($clients as $client)
                                                    <option value="{{$client->id}}" {{$projects->client_id == $client->id ? 'selected' : '' }}>{{$client->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                
                                    

                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <br/>
                        <div>
                            <div class="text-center">
                                <button  type="submit" class="btn" style="border: 1px solid gray;
                                         background: #0ABAB5 !important; height: 50px; width: 150px;color:#fff!important">Save

                                </button>
                            </div>
                            <br/>  <br/>
                        </div>
                        </form>
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