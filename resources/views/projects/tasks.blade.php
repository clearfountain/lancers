@extends('layouts.auth')
@section('style-ext')
    <link type="text/css" rel="stylesheet" href="{{ asset('css/tasks.css') }}" />
@endsection


@section('main-content')
    <section class="">
        <div class="container-fluid">
            <div class="">
                <h1 style="margin-top: 15px;">Tasks </h1>
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
                        <li class="navi-links"><a href="{{url('project/collaborators')}}">Collaborators</a></li>
                        <li class="navi-links navi-active"><a href="javascript:void(0)">Task</a></li>
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
                                <th scope="col">Date</th>
                                <th scope="col">Project</th>
                                <th scope="col">Task</th>
                                <!-- <th scope="col">Progress</th> -->
                                <th class="text-left" scope="col">Status</th>
                                <th class="text-left" scope="col">Team</th>
                                <th scope="col"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($tasks) && count($tasks) < 1)
                            <tr class="py-2">
                                <td scope="row" class="rounded-left border border-right-0" colspan="7">No Tasks Assigned</td>
                            </tr>
                            @else
                            @foreach($tasks as $task)
                            <tr class="py-2">
                                <td scope="row" class="rounded-left border border-right-0">
                                    <span class="text-small text-muted mr-2">
                                        <i class="fas fa-circle"></i>
                                    </span>
                                    <span class="">{{$task->created_at}}</span>
                                </td>
                                <td class="border-top border-bottom">{{$task->project_title}}</td>
                                <td class="border-top border-bottom">{{$task->task_title}}</td>
                                <!-- <td class="border-top border-bottom">
                                    <span class="alert alert-primary py-0 px-2 small m-0">{{$task->progress}}%</span>
                                </td> -->
                                <td class="border-top border-bottom text-left">
                                <span class="alert {{$task->status == 'pending' ? 'alert-default' 
                                    : $task->status == 'in-progress' ? 'alert-warning' : 'alert-success' }}
                                    alert-primary py-0 px-2 small m-0 active">{{ucfirst($task->status) }}</span>
                                </td>
                                <td class="border-top border-bottom text-right" style="text-align:right;">
                                    <div style="position: relative;" style="float: right;" align="right">
                                        <img src="https://res.cloudinary.com/memz/image/upload/v1570714781/download_2_yhhlsm.jpg"
                                            width="30px" height="30px" class="woman1" />
                                        <img src="https://res.cloudinary.com/memz/image/upload/v1570714759/download_3_aym7zh.jpg"
                                            width="30px" height="30px" class="woman2" />
                                        <img src="https://res.cloudinary.com/memz/image/upload/v1570714722/download_4_hqdpcn.jpg"
                                            width="30px" height="30px" class="woman3" />
                                    </div>
                                </td>
                                <td class="rounded-right border border-left-0">
                                    <div class="dropdown dropleft">
                                        <a class="btn btn-white btn-sm dropdown-toggle" href="#" role="button"
                                            id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item text-success" href="{{url('#')}}"><i
                                                class="fas fa-binoculars"></i> View
                                            </a>
                                            <a class="dropdown-item text-secondary" href="{{url('#')}}"><i
                                                class="fas fa-edit"></i> Edit
                                            </a>
                                            <a class="dropdown-item text-danger" href="{{url('#')}}"><i
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
                    <h5 class="modal-title"> Add New Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{url('project/task/create')}}">
                    @csrf
                    <div class="modal-body">                       
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Select Project:</label>
                                    <select required class="form-control" name="project_id" id="selectProject">
                                        <option>Select Project</option>
                                        @foreach($projects as $project)
                                        <option required value="{{$project->id}}">{{$project->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Select Collaborator: </label>
                                    <select required class="form-control" name="user_id" id="selectProject">
                                        <option> Select Collaborator </option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Task:</label>
                            <input required type="text" name="title" class="form-control" id="message-text">
                        </div>
                        <div class="form-group">
                            <label for="desc" class="col-form-label">Desciption:</label>
                            <textarea required name="description" class="form-control" id="desc"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                        <label for="start" class="col-form-label">Start Date:</label>
                                        <input required type="date" name="start_date" class="form-control" id="start">
                                    
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                        <label for="end" class="col-form-label">End Date:</label>
                                        <input required type="date" name="due_date" class="form-control" id="end">
                                    
                                </div>
                            </div>
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
@endsection

@section('script')
    <script>
        // $(document).ready(function () {
        //     $('#sidebarCollapse').on('click', function () {
        //         $('#sidebar').toggleClass('active');
        //         $(this).toggleClass('active');
        //     });

        //     $('#myModal').on('shown.bs.modal', function () {
        //         $('#myInput').trigger('focus')
        //     });
        //     $('.table-responsive').on('show.bs.dropdown', function () {
        //         $('.table-responsive').css( "overflow", "inherit" );
        //     });

        //     $('.table-responsive').on('hide.bs.dropdown', function () {
        //         $('.table-responsive').css( "overflow", "auto" );
        //     })
                    
        // });


        let selectStatus = document.querySelector('#select-filter');
        selectStatus.addEventListener('change', function(){
            // this.form.action = "/projects?status="+selectStatus.value;
            // this.form.submit();
            if(selectStatus.value == 'all') window.location.href="/project/tasks";
            else window.location.href="/project/tasks?filter="+selectStatus.value;
        }, false)
    </script>
@endsection