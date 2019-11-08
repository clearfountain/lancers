@extends('layouts.auth')
@section('title', 'Edit Contact')


@section('main-content')
  <link rel="stylesheet" type="text/css" href="{{asset('css/add_client.css')}}" />
    <style> a:hover{cursor: pointer;}</style>
<div class="container-fluid">

    {{-- {{$client}} --}}
    <main>

        <form method="post" action="/clients/edit" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <input type="hidden" name="client_id" value="{{$client->id}}">
            <h2>Edit Client Details</h2><br>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('success'))<br> <h6><span class="alert alert-success">{{session('success')}}</span></h6>
            @elseif(session('error'))<br> <h6><span class="alert alert-danger">{{session('error')}}</span></h6> @endif
            <div class="clearfix"></div>
            <section class="content">
                <i><strong>Click image to select client image for upload</strong></i>
                </br>
                 @if(null != $client->profile_picture)
                <img id="invoice_image_selecter" src="{{asset($client->profile_picture)}}" style="width: 100px; height: 100px; border-radius: 10%; pointer: finger;" alt="Client Image">
                @endif
                @if(null == $client->profile_picture)
                <img id="invoice_image_selecter" src="{{ asset('images/ClientImages/user-default.jpg') }}" style="width: 100px; height: 100px; border-radius: 10%; pointer: finger;" alt="Client Image">
                @endif
                </br>
                <h4>Business Information</h4>
                <div class="form-group">
                    <label for="company_name">Company name</label>
                    <input type="text" name="name" value="{{$client->name ?? ''}}" class="form-control" required id="Cname" placeholder="e.g Sunshine Studio">
                </div>

                <input id="invoice_picture" name="profileimage" type="file" style="visibility: hidden;"  onchange="invoiceImage(this);" />

                <h5>Business Address</h5>
                <div>
                    <div class="form-group">
                        <label for="Str_Num">Street & Number</label>
                        <span>
                            <input class="form-control" type="text" name="street" id="street" placeholder="Street" value="{{$client->street ?? ''}}">
                            <input  type="number" min="0" class="form-control" name="street_number" id="number" placeholder="Number" value="{{$client->street_number ?? ''}}">
                        </span>

                        <label for="city_Zcode">City & Zip Code</label>
                        <span>
                            <input type="text"  class="form-control" name="city" id="city" placeholder="City" value="{{$client->city ?? ''}}">
                            <input type="number" min="0" class="form-control" name="zipcode" id="Zcode" placeholder="Zip code" value="{{$client->zipcode ?? ''}}">
                        </span>

                        <label for="Country_state">Country & State</label>
                        <span>
                            <select required name="country_id" class="country">
                                <option value="" selected>Country</option>
                                @foreach($countries as $country)
                                    <option {{$client->country_id == $country->id ? 'selected' : ''}} value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>

                            <select required name="state_id" class="country">

                                <option value="" selected>Select State</option>
                                @foreach($states as $key => $state)
                                    <option {{$client->state_id == $state['id'] ? 'selected' : ''}} value="{{$state['id']}}" >{{$state['name']}}</option>
                                @endforeach
                            </select>
                            <!-- <input required type="text" name="state" id="state" placeholder="state"> -->
                        </span>
                    </div>

                    <h5>Contact Information</h5>
                    <span id="contacts">

                        @foreach($client->contacts ?? [] as $key => $contact)
                            <div class="form-group">
                                <label for="company_name_{{$key}}">Contact name</label>
                                <input type="text" value="{{$contact['name']}}" class="form-control" name="contact[{{$key}}][name]" id="contact_name{{$key}}" placeholder="e.g Ben Davies">

                                <label for="company_email_{{$key}}">Contact email</label>
                                <input class="form-control" value="{{$contact['email']}}" type="email" name="contact[{{$key}}][email]" id="email_{{$key}}" placeholder="e.g email@domain.com">
                            </div>
                        @endforeach
                    </span>
                    <h5><a onClick="addContact()">Add other contacts &nbsp; +</a></h5>
                </div>
            </section>
            <section>
                <button type="submit" class="create-invoice">Save client details</button>
            </section>
        </form>
    </main>
</div>
@endsection

@section('script')
<script type="text/javascript">


 //jquery code for handling client image upload
 $("#invoice_image_selecter").on("click", function() {
        $("#invoice_picture").trigger("click");
      });



      function invoiceImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#invoice_image_selecter')
                    .attr('src', e.target.result)
                    .width(100)
                    .height(100);
            };

            reader.readAsDataURL(input.files[0]);
        }

    }


    let count = {{count($client->contacts ?? [])}};
	window.addEventListener('load', function() {
        //{{--addStates({{$client->country_id}}) --}}
    })
    function addContact(){
        let element = document.querySelector('#contacts')
        let newElement = document.createElement('div');
        newElement.classList.add('form-group');
        newElement.innerHTML = `
            <label for="company_name_${count}">Contact name</label>
            <input type="text" ${count == 0 ? 'required' : ''} class="form-control" name="contact[${count}][name]" id="contact_name${count}" placeholder="e.g Ben Davies">

            <label for="company_email">Contact email</label>
            <input class="form-control" type="email" ${count == 0 ? 'required' : ''} name="contact[${count}][email]" id="email_${count}" placeholder="e.g email@domain.com">
        `;
        element.appendChild(newElement);
        count+=1;
    }

    $(document).ready(function() {
        $('select[name="country_id"]').on('change', function() {
            let countryID = $(this).val();
            addStates(countryID);
        });
    });

    function addStates(countryID){
        if(countryID) {
            $.ajax({
                url: '/states/'+encodeURI(countryID),
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('select[name="state_id"]').empty();
                    $('select[name="state_id"]').append('<option selected value="">Select State</option>');
                    $.each(data.data, function(key, value) {
                        $('select[name="state_id"]').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                }
            });
        }else{
            $('select[name="state_id"]').empty();
        }
    }
</script>
@endsection
