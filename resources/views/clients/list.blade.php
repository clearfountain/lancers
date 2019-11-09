@extends('layouts.auth')
@section('style')

@endsection


@section('main-content')
<section class="">
    <div class="container-fluid">
        <h1 style="margin-top: 15px; margin-bottom: 15px;">Clients </h1>
        <div class="">
            <div class="">
                <form class="form-inline" style="display: inline-block; margin-top: 10px;">
                    <select  class="form-control" id="select-filter">

                        <option value="all" @if (Request()->filter) {{ 'selected' }} @endif >All</option>
                        <option value="pending" @if (Request()->filter && Request()->filter == 'pending') {{ 'selected' }} @endif>Pending</option>
                        <option value="completed" @if (Request()->filter && Request()->filter == 'completed') {{ 'selected' }} @endif>Completed</option>
                    </select>
                </form>
                &nbsp;  <a href="{{url('clients/add')}}">    <button class='create-invoice' style="height:40px!important;border-radius: 4px 4px "> <span class="fa fa-plus"> </span> Add New Client</button> </a>

            </div>
                        @if(session('success'))<br> <h6><span class="alert alert-success">{{session('success')}}</span></h6>
            @elseif(session('error'))<br> <h6><span class="alert alert-danger">{{session('error')}}</span></h6> @endif
            <div class="table-responsive">
                <table class="table project-table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col" class="text-center">Company</th>
                            <th scope="col">Name</th>
                            <th scope="col">Project</th>
                            <th  scope="col">Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                        <tr class="py-2">
                            <td scope="row" class="rounded-left border border-right-0">
                                <span class="text-small text-muted mr-2">
                                    <i class="fas fa-circle"></i>
                                </span>
                                <span class="">{{date('d/m/Y', strtotime($client->created_at))}}</span>
                            </td>
                            <td class="border-top border-bottom titles text-center">
								@if($client->profile_picture !== null)
								<img id="image_selecter" src="{{ asset($client->profile_picture) }}" style="width: 30px; height: 30px; border-radius: 10%; pointer: finger;" alt="Profile Image">
								@else
								<img id="image_selecter" src="{{ asset('images/company-default.svg') }}" style="width: 30px; height: 30px; border-radius: 10%; pointer: finger;" alt="Profile Image">
								@endif
							</td>
                            <td class="border-top border-bottom ">{{$client->name}}</td>

                            <td class="border-top border-bottom">
                                @forelse($client->projects as $project)
                                {{ $loop->first ? '' : ', ' }}
                                {{$project->title}}
                                @empty
                                <span style="color: red;">No Project Yet</span>
                                @endforelse
                            </td>

                            <td class="border-top border-bottom">
                                <span class="alert alert-primary py-0 px-2 small m-0 pending">
                                    @forelse($client->projects as $project)
                                    {{ $loop->first ? '' : ', ' }}
                                    {{ucfirst($project->status)}}
                                    @empty
                                    <span style="color: red;">Not Available<span>
                                    @endforelse
                                </span>
                            </td>
                            <td class="rounded-right border border-left-0">
                                <div class="dropdown dropleft">
                                    <a class="btn btn-white btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item text-success" href="/clients/view/{{$client->id}}"><i class="fas fa-binoculars"></i> View</a>
                                        <a class="dropdown-item text-secondary" href="/clients/{{$client->id}}/edit"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="" data-id="{{$client->id}}" class="dropdown-item text-danger delete-btn"><i class="fas fa-trash-alt"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                            <form action="/clients/{{$client->id}}/delete" method="post" id="delete-{{$client->id}}">
                                @csrf
                                @method('delete')
                            </form>
                        </tr>


                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection


@section('others')
<button class="btn btn-secondary text-white rounded-circle" id="add-something" onclick="location.href='{{url('/clients/add')}}'">
    <i class="fas fa-plus"></i>
</button>


<div class="modal" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmMessage"> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                <a href="" id="delLink"><button class="btn btn-primary modal-save">YES I DO</button></a>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                <button class="btn btn-primary modal-close" data-dismiss="modal">NO I DO NOT</button>
                                </div>
                            </div>
                        </div>


                    </div>


            </div>
          </div>
          </div>
@endsection

@section('scripting')
<script>
    //alert(11);
    let select = document.querySelector('#select_status');
    console.log(select);
    select.addEventListener('change', function () {
        this.form.submit();
    }, false);
</script>
@endsection


@section('script')
    <script>
        let selectStatus = document.querySelector('#select-filter');
        selectStatus.addEventListener('change', function(){
            if(selectStatus.value == 'all') window.location.href="/clients";
            else window.location.href="/clients?filter="+selectStatus.value;
        }, false)



        $(".delete-btn").on('click', e => {
            e.preventDefault();

            let id = e.target.dataset.id;

            //get client details from app
            $.get(
                `/clients/details/json/${id}`,
                function(data,status)
                {
                const url = "{{ url('/')}}/clients/";
                let urlLink = url+id+"/delete";
                //use spread operator to convert response array to object
                let clientObject = JSON.parse(JSON.stringify(...data));
                $("#delLink").attr("href", urlLink);
                $("#confirmMessage").html(`Do you want to delete client with name ${clientObject.name.toUpperCase()} and email ${clientObject.email}`);
                //fire confirmation dialogue
                $("#myModal").modal();

           /*     var confirmation = confirm(`Do you want to delete client with name ${clientObject.name.toUpperCase()} and email ${clientObject.email}`);
              //run switch statement after dialogue
            switch(true){
                case confirmation == true: $(`#delete-${id}`).submit();
                break;
                case confirmation == false: alert("Client delete aborted");
                break;
                default: alert("Please select Ok or Cancel to proceed with Client delete");
                break;
            }
            */

                }
            );

        });

            </script>
@endsection
