@extends('layouts.auth')
@section('style')

@endsection


@section('main-content')
<div class="container">
    <a href="{{url('estimate/create/step1')}}"> <button class='create-invoice'>Create Invoice</button> </a>
</div>
<section class="">
    <div class="container-fluid">
        <h4 class="mt-0 text-primary">Invoices</h4>
        @if(session()->has('message.alert'))
        <div class="text-center">
            <button class=" alert alert-{{ session('message.alert') }}">
                {!! session('message.content') !!}
            </button>
        </div>
        @endif
        <div class="">
            <div class="">
                <form class="form-inline">
                    <select class="form-control" id="select-filter">
                        <option value="all" @if (Request()->filter) {{ 'selected' }} @endif >All</option>
                        <option value="paid" @if (Request()->filter && Request()->filter == 'paid') {{ 'selected' }} @endif>Paid</option>
                        <option value="unpaid" @if (Request()->filter && Request()->filter == 'unpaid') {{ 'selected' }} @endif>Unpaid</option>
                    </select>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table project-table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">Invoice</th>
                            <th scope="col">Client</th>
                            <th scope="col">Project</th>
                            <th scope="col">Issued</th>
                            <th scope="col">Status</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Amount Paid</th>

                            <th scope="col"> </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($invoices) && count($invoices) < 1) <tr class="py-2">
                            <td scope="row" class="rounded-left border border-right-0" colspan="7">No Invoice found</td>
                            </tr>
                            @else
                            @php $count = 1; @endphp
                            @foreach($invoices as $invoice)
                            <tr class="py-2">
                                <td class="border-top border-bottom titles"># {{$count}}</td>
                                <td class="border-top border-bottom titles">{{$invoice->estimate->project->client->name}}</td>
                                <td class="border-top border-bottom titles">{{$invoice->estimate->project->title}}</td>
                                <td class="border-top border-bottom titles">{{$invoice->created_at}}</td>

                                <td class="border-top border-bottom">
                                    <span class="alert alert-{{$invoice->status == 'paid' ? 'success' : 'danger'}} py-0 px-2 small m-0 pending">{{ucfirst($invoice->status)}}</span>
                                </td>
                                <td class="border-top border-bottom titles">{{$invoice->currency->symbol}}{{$invoice->amount}}</td>
                                <td class="border-top border-bottom titles">{{$invoice->currency->symbol}}{{$invoice->amount_paid}}</td>

                                <td class="rounded-right border border-left-0">
                                    <div class="dropdown dropleft">
                                        <a class="btn btn-white btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item text-success" href="{{url('/')}}/invoices/{{$invoice->id}}" <i class="fas fa-binoculars"></i> View</a>
                                            <a class="dropdown-item text-secondary" href="{{ url('/')}}/invoice/edit/{{ $invoice->id }}" <i class="fas fa-edit"></i> Edit</a>
                                            <a class="dropdown-item text-danger" href="{{ url('/')}}/invoice/remove/{{ $invoice->id }}"><i class="fas fa-trash-alt"></i> Delete</a>
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
<a href="{{url('estimate/create/step1')}}"><button class="btn btn-secondary text-white rounded-circle" id="add-something">
    <i class="fas fa-plus"></i>
</button></a>
@endsection


@section('script')
<script>
    let selectStatus = document.querySelector('#select-filter');
    selectStatus.addEventListener('change', function() {
        if (selectStatus.value == 'all') window.location.href = "/invoices";
        else window.location.href = "/invoices?filter=" + selectStatus.value;
    }, false)
</script>
@endsection