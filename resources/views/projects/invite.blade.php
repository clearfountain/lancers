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

                 @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
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
                        <li class="navi-links"><a href="{{url('project/tasks')}}">Task</a></li>
                        <li class="navi-links navi-active"><a href="javascript:void(0)">Invite</a></li>
                        <!-- <li class="navi-links"><a href="#">Documents</a></li> -->
                    </ul>
                </div>
                <div class="table-responsive">
                {{--  <form action="{{ url('project/invite') }}" 
                    method="post">{{ csrf_field() }}
                    <input type="email" name="email" />
                    <button type="submit">Invite</button>
                </form>  --}}

                 
                    <table class="table project-table table-borderless">
                        <thead>
                            <tr>
                              
                                <th scope="col">Email</th>
                                <th scope="col">Project</th>
                                <th scope="col">Role</th>
                                <th scope="col"> status </th>
                            </tr>
                        </thead>
                        <tbody>
                        
                            @if(isset($invites) && count($invites) < 1)
                            <tr class="py-2">
                                <td scope="row" class="rounded-left border border-right-0" colspan="5">No invitee found for your projects</td>
                            </tr>
                            @elseif(isset($invites))
                            @foreach($invites as $invite)
                            <tr class="py-2">
                             
                                <td class="border-top border-bottom">{{$invite->email}}</td>
                                <td class="border-top border-bottom">{{$invite->project->title}}</td>
                               
                                <td class="border-top border-bottom">{{ucfirst($invite->role) }}</td>
                                 <td class="border-top border-bottom">
                                    <span class="alert alert-primary py-0 px-2 small m-0">{{$invite->status}}</span>
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
                    <h5 class="modal-title"> Invite New Collaborator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{url('project/invite/send')}}">
                {!! csrf_field() !!}
                    <div class="modal-body">                       
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Select Project:</label>
                                    <select required class="form-control" name="project" id="selectProject">
                                        <option>Select Project</option>
                                        @foreach($projects as $project)
                                        <option value="{{$project->id}}">{{$project->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                  <div class="form-group">
                                    <label for="message-text" class="col-form-label">Email:</label>
                                    <input type="text" required name="email"  class="form-control" id="message-text">
                                 </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Specify Role:</label>
                            <input type="text" required name="role" maxlength="20" class="form-control" id="message-text">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary modal-save">Send Invite</button>
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
            if(selectStatus.value == 'all') window.location.href="/project/invite";
            else window.location.href="/project/invite?filter="+selectStatus.value;
        }, false)
    </script>
@endsection