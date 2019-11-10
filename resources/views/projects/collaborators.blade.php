@extends('layouts.auth')
@section('style-ext')
    <link type="text/css" rel="stylesheet" href="{{ asset('css/tasks.css') }}" />
@endsection


@section('main-content')
    <section class="">
        <div class="container-fluid">
            <div class="">
                <h1 style="margin-top: 15px;">Collaborators </h1>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('errors'))
                    <div class="alert alert-danger">
                        {{ session('errors') }}
                    </div>
                @endif
                <!-- @if (!empty($errors))
                <span class='help-block'>
                    <strong>{{ "Some input field is not properly filled" }}</strong>
                </span>
                @endif -->
                <div style=" background-color: #091429;">
                    <ul class="navi-ul">
                        <!-- <li class="navi-links"><a href="#">Overview</a></li> -->
                        <li class="navi-links navi-active"><a href="javascript:void(0)">Collaborators</a></li>
                        <li class="navi-links"><a href="{{url('project/tasks')}}">Task</a></li>
                        <li class="navi-links"><a href="{{url('project/invite')}}">Invite</a></li>
                        <!-- <li class="navi-links"><a href="#">Documents</a></li> -->
                    </ul>
                </div>
                <div class="table-responsive">
                    <div class="">
                        <form class="form-inline" method="GET">
                            <select class="form-control" id="select-filter">
                                <option value="all" @if (Request()->filter) {{ 'selected' }} @endif >All</option>
                                <option value="pending" @if (Request()->filter && Request()->filter == 'pending') {{ 'selected' }} @endif>Pending</option>
                                <option value="in-progress" @if (Request()->filter && Request()->filter == 'in-progress') {{ 'selected' }} @endif>In Progress</option>
                                <option value="completed" @if (Request()->filter && Request()->filter == 'completed') {{ 'selected' }} @endif>Completed</option>
                            </select>
                        </form>
                    </div>

                    <table class="table project-table table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">Avatar</th>
                                <th scope="col">Name</th>
                                <th scope="col">Project</th>
                                <th scope="col">Role</th>
                                <th scope="col"> </th>
                            </tr>
                        </thead>
                        <tbody>

                            @if(isset($collabo) && count($collabo) < 1)
                            <tr class="py-2">
                                <td scope="row" class="rounded-left border border-right-0" colspan="5">No Collaborators found for your projects</td>
                            </tr>
                            @elseif(isset($collabo))
                            @foreach($collabo as $collabo)
                            <tr class="py-2">
                                <td  class="rounded-left border border-right-0">
                                    @if( $collabo->toArray()['profile_picture'] !== 'user-default.png')
                                    <img id="image_selecter" src="{{ asset($collabo->toArray()['profile_picture']) }}" style="width: 30px; height: 30px; border-radius: 50%; pointer: finger;" alt="Profile Image">
                                    @endif
                                    @if( $collabo->toArray()['profile_picture'] == 'user-default.png')
                                    <img id="image_selecter" src="{{ asset('images/user-default.jpg') }}" style="width: 30px; height: 30px; border-radius: 10%; pointer: finger;" alt="Profile Image">
                                    @endif
                                </td>
                                <td class="border-top border-bottom">{{$collabo->name}}</td>
                                <td class="border-top border-bottom">{{$collabo->project_title}}</td>
                                <!-- <td class="border-top border-bottom">
                                    <span class="alert alert-primary py-0 px-2 small m-0">{{$collabo->progress}}%</span>
                                </td> -->
                                <td class="border-top border-bottom">{{ucfirst($collabo->role) }}</td>
                                <td class="rounded-right border border-left-0">
                                    <div class="dropdown dropleft">
                                        <a class="btn btn-white btn-sm dropdown-toggle" href="#" role="button"
                                            id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            {{--  <a class="dropdown-item text-success" href="{{url('#')}}"><i
                                                class="fas fa-binoculars"></i> View
                                            </a>
                                              --}}

                                            <a class="dropdown-item text-secondary" href="{{ url('/')}}/project/collaborator/edit/{{ $collabo->id }}"><i
                                                class="fas fa-edit"></i> Edit
                                            </a>
                                            <a class="dropdown-item text-danger" data-id="{{ $collabo->id}}:{{$collabo->name}}" href=""><i
                                                class="fas fa-trash-alt"></i> Delete
                                            </a>

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
    <button class="btn btn-secondary text-white rounded-circle" id="add-something">
        <i class="fas fa-plus"></i>
    </button>

    <button class="btn btn-secondary text-white rounded-circle" id="add-something" data-toggle="modal"
        data-target="#myModal">
        <i class="fas fa-plus"></i>
    </button>
    <div class="modal" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Add New Collaborator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{url('project/collaborator/create')}}">
                {!! csrf_field() !!}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Select Project:</label>
                                    <select required class="form-control" name="project_id" id="selectProject">
                                        <option>Select Project</option>
                                        @foreach($projects as $project)
                                        <option value="{{$project->id}}">{{$project->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Add Collaborator: </label>
                                    <select required class="form-control" name="user_id" id="selectProject">
                                        <option> Add Collaborator </option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Specify Role:</label>
                            <input type="text" required name="role" maxlength="20" class="form-control" id="message-text">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary modal-save">Save changes</button>
                        <button type="submit" class="btn btn-primary modal-close" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="myModal2">
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

@section('script')
    <script>

         const url = "{{ url('/')}}/project/collaborator/remove/";
    //alert for invoice delete
    $('.text-danger').on("click",function(e){
            e.preventDefault();
            let collabObject = e.target.dataset.id;
            let collabObjectArray = collabObject.split(":");
            let urlLink = url+collabObjectArray[0];
            let collaboName = collabObjectArray[1].toUpperCase();
            $("#delLink").attr("href", urlLink);
            $("#confirmMessage").html(`DO YOU WANT TO DELETE COLLABORATOR WITH NAME ${collaboName} ?`);
            $("#myModal2").modal();

      /*  var confirmation = confirm(`Do you want to delete invoice with project name ${invoiceObjectArray[1].toUpperCase()}`);
              //run switch statement after dialogue
            switch(true){
                case confirmation == true: window.location = url+invoiceObjectArray[0];
                break;
                case confirmation == false: alert("Invoice delete aborted");
                break;
                default: alert("Please select Ok or Cancel to proceed with Invoice delete");
                break;
            }
        */

    });

        let selectStatus = document.querySelector('#select-filter');
        selectStatus.addEventListener('change', function(){
            // this.form.action = "/projects?status="+selectStatus.value;
            // this.form.submit();
            if(selectStatus.value == 'all') window.location.href="/project/collaborators";
            else window.location.href="/project/collaborators?filter="+selectStatus.value;
        }, false)
    </script>
@endsection
