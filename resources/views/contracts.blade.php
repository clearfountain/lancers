@extends('layouts.auth')
@section('style')

@endsection


@section('main-content')
    <div class="container">
        <button class='create-Contract' onClick="window.location.href('./contract/create')">Create Contract</button>
    </div>
    <section class="">
        <div class="container-fluid">
            <h4 class="mt-0 text-primary">Contracts</h4>
            <div class="">
                <div class="">
                    <form class="form-inline">
                        <select class="form-control" id="select-filter">
                            <option value="all" @if (Request()->filter) {{ 'selected' }} @endif >All</option>
                            <option value="completed" @if (Request()->filter && Request()->filter == 'completed') {{ 'selected' }} @endif>Completed</option>
                            <option value="pending" @if (Request()->filter && Request()->filter == 'pending') {{ 'selected' }} @endif>Pending</option>
                        </select>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table project-table table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">Contract</th>
                                <th scope="col">Client</th>
                                <th scope="col">Project</th>
                                <th scope="col">Issued</th>
                                <th scope="col">Status</th>                             
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($contracts) && count($contracts) < 1)
                            <tr class="py-2">
                                <td scope="row" class="rounded-left border border-right-0" colspan="7">No Contract found</td>
                            </tr>
                            @else
                                @php $count = 1; @endphp
                                @foreach($contracts as $contract)
                                <tr class="py-2">
                                    <td class="border-top border-bottom titles"># {{$count}}</td>
                                    <td class="border-top border-bottom titles">{{$contract->project->client->name}}</td>
                                    <td class="border-top border-bottom titles">{{$contract->project->title}}</td>
                                    <td class="border-top border-bottom titles">{{$contract->created_at}}</td>
                                    <td class="border-top border-bottom">
                                        <span class="alert alert-primary py-0 px-2 small m-0 pending">{{$contract->status}}</span>
                                    </td>

                                    <td class="rounded-right border border-left-0">
                                        <div class="dropdown dropleft">
                                            <a class="btn btn-white btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item text-success" href="#"><i class="fas fa-binoculars"></i> View</a>
                                                <a class="dropdown-item text-secondary" href="#"><i class="fas fa-edit"></i> Edit</a>
                                                <a class="dropdown-item text-danger" href="#"><i class="fas fa-trash-alt"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @php $count+=1; @endphp
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
@endsection


@section('script')
    <script>
        let selectStatus = document.querySelector('#select-filter');
        selectStatus.addEventListener('change', function(){
            if(selectStatus.value == 'all') window.location.href="/contracts";
            else window.location.href="/contracts?filter="+selectStatus.value;
        }, false)
    </script>
@endsection