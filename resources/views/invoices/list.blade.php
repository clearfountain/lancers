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

                            @if("object" == gettype($invoice->estimate->project->client))

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
                                            <a class="dropdown-item text-success" href="{{url('/')}}/invoices/{{$invoice->id }}/getpdf"> <i class="fas fa-binoculars"></i> View</a>
                                            <a class="dropdown-item text-secondary" href="{{ url('/')}}/invoice/edit/{{ $invoice->id }}"> <i class="fas fa-edit"></i> Edit</a>
                                            <a class="dropdown-item text-danger" data-id="{{ $invoice->id }}:{{$invoice->estimate->project->title}}" href=""><i class="fas fa-trash-alt"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            @php $count+=1; @endphp
                            @endif
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

@section('script')
<script>
const url = "{{ url('/')}}/invoice/remove/";
    //alert for invoice delete
    $('.text-danger').on("click",function(e){
            e.preventDefault();
            let invoiceObject = e.target.dataset.id;
            let invoiceObjectArray = invoiceObject.split(":");
            let urlLink = url+invoiceObjectArray[0];
            let projectName = invoiceObjectArray[1].toUpperCase();
            $("#delLink").attr("href", urlLink);
            $("#confirmMessage").html(`DO YOU WANT TO DELETE INVOICE WITH PROJECT NAME ${projectName} ?`);
            $("#myModal").modal();

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
    selectStatus.addEventListener('change', function() {
        if (selectStatus.value == 'all') window.location.href = "/invoices";
        else window.location.href = "/invoices?filter=" + selectStatus.value;
    }, false)



</script>
@endsection
