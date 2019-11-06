@extends('layouts.auth')
@section('style')

@endsection


@section('main-content')

<section class="">
    <div class="container-fluid">
        <h1 style="margin-top: 15px">Projects </h1>


        <div class="">
            <div class="">
                <form class="form-inline" method="GET" style="display: inline-block; margin-top: 10px;">
                    <select class="form-control" id="select-filter">
                        <option value="all" @if (Request()->filter) {{ 'selected' }} @endif >All</option>
                        <option value="pending" @if (Request()->filter && Request()->filter == 'pending') {{ 'selected' }} @endif>Pending</option>
                        <option value="active" @if (Request()->filter && Request()->filter == 'active') {{ 'selected' }} @endif>Active</option>
                        <option value="completed" @if (Request()->filter && Request()->filter == 'completed') {{ 'selected' }} @endif>Completed</option>
                    </select>
                </form>
            </div>
              @if(session()->has('message.alert'))
            <div class="text-center">
                <button class=" alert alert-{{ session('message.alert') }}"> 
                    {!! session('message.content') !!}
                </button>
            </div>
            @endif
            <div class="table-responsive">
                <table class="table project-table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Title</th>
                            <th scope="col">Start Date</th>
                            <th class="text-right" scope="col">Paid</th>
                            <th class="text-right" scope="col">Due</th>
                            <th scope="col">Status</th>
                            <th scope="col"> </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($projects) && count($projects) < 1)
                        <tr class="py-2">

                            <td scope="row" class="rounded-left border border-right-0" colspan="7">No project found</td>
                        </tr>
                        @else
                        @foreach($projects as $project)
                        <tr class="py-2">
                            <td scope="row" class="rounded-left border border-right-0">
                                <span class="text-small text-muted mr-2">
                                    <i class="fas fa-circle"></i>
                                </span> 
                                <span class="">{{date('d/m/Y', strtotime($project->created_at))}}</span>
                            </td>
                            <td class="border-top border-bottom titles">{{$project->title}}</td>
                            <td class="border-top border-bottom">
                                @foreach($project->user->estimate as $esti)
                                {{$esti->start}}
                                @endforeach

                            </td>
                            <td class="border-top border-bottom text-right">
                                @foreach($project->user->estimate as $esti)
                                {{$esti->invoice->currency->symbol}}{{number_format($esti->invoice->amount_paid)}}
                                @endforeach


                            </td>
                            <td class="border-top border-bottom text-right">
                                @foreach($project->user->estimate as $esti)
                                {{$esti->invoice->currency->symbol}}{{number_format($esti->invoice->amount)}}
                                @endforeach



                            </td>
                            <td class="border-top border-bottom">
                                <span class="alert alert-primary py-0 px-2 small m-0 pending">
                                    {{ucfirst($project->status)}}
                                </span>
                            </td>
                            <td class="rounded-right border border-left-0">
                                <div class="dropdown dropleft">
                                    <a class="btn btn-white btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item text-success" href="{{url('view-project',['id'=>$esti->id])}}"><i class="fas fa-binoculars"></i> View</a>
                                        <a class="dropdown-item text-secondary" href="{{url('edit-project',['id'=>$esti->id])}}" ><i class="fas fa-edit"></i> Edit</a>
                                      
                                        <form  class="deleted"   role="form" method="POST"
                                               action="{{url('delete-project',['id'=>$esti->id])}}" >
                                             @csrf
                                            <button  class="dropdown-item text-danger noHover" type="submit"> <i class="fas fa-trash-alt"></i> Delete</button>
                                        </form>
                                        @if($project->status == 'pending')
                                        <form  class="deleted"   role="form" method="POST"
                                               action="{{url('completed-project',['id'=>$esti->id])}}" >
                                             @csrf
                                            <button  class="dropdown-item text-success noHover" type="submit"> <i class="fas fa-check-circle"></i> Mark Completed</button>
                                        </form>
                                        @else
                                        <form  class="deleted"  role="form" method="POST"
                                               action="{{url('pending-project',['id'=>$esti->id])}}" >
                                             @csrf
                                            <button  class="dropdown-item text-danger noHover" type="submit"> <i class="fas fa-question-circle"></i> Mark Pending</button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>


                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection


@section('others')
<!-- <a href="#"><button class="btn btn-secondary text-white rounded-circle" id="add-something">
    <i class="fas fa-plus"></i></a> -->
<button class="btn btn-secondary text-white rounded-circle" id="add-something">
    <a href="{{url('estimate/create/step1')}}">    <i class="fas fa-plus"></i> </a>
</button>
@endsection

@section('script')

<script>
    $('#myModal').appendTo("body").modal('show');
    $(".deleted").on("submit", function () {

        return confirm("Are you sure?");
    });
</script>
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