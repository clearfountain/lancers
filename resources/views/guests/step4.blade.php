@extends('layouts.app')
<!-- Select Project -->

@section('styles')
<link rel="stylesheet" href="{{asset('css/step4.css')}}" />
@endsection


@section('content')

<form id="form" onsubmit="submitEvent(event)" method="post" action="/guest/save/step3">
    @csrf
    <div id="container">

        <div class=" text-center">
            <a class="icon-btn" id="icon-close">
                <span><i class="icon-btn fa fa-times"></i></span>
            </a>
        </div>

        <div class="text-center">
            <a class="icon-btn" id="icon-back">
                <span><i class="icon-btn fa fa-chevron-left"></i></span>
            </a>
        </div>

        <div class="text-center">
            <p class="">Create Client</p>
        </div>

        <div class="">
            <input class="text-center cnc" id="step4UpperButton" value="NEXT" type="button">
        </div>

    </div>

    <div class="container-fluid main-section">

        <main>
            <h2>Client Information</h2>
            <br>
            {{-- <h2>Client Information</h2><br>  --}}
            @if(session('success'))<br>
            <h6><span class="alert alert-success">{{session('success')}}</span></h6>
            @elseif(session('error'))<br>
            <h6><span class="">{{session('error')}}</span></h6> @endif

            @if(session()->has('message.alert'))
            <div class="text-center">
                <button class=" alert alert-{{ session('message.alert') }}">
                    {!! session('message.content') !!}
                </button>
            </div>
            @endif
            <section class="content">
                <h4>Business Information</h4>
                <div class="form-group">
                    <label for="company_name">Company name</label>
                    <input type="text" name="name" required id="Cname" placeholder="e.g Sunshine Studio">
                </div>

                <h5>Business Address</h5>
                <div>
                    <div class="form-group">
                        <label for="Str_Num">Street & Number</label>
                        <span>
                            <input required type="text" name="street" id="street" placeholder="Street">
                            <input required type="number" min="0" name="street_number" id="number" placeholder="Number">
                        </span>

                        <label for="city_Zcode">City & Zip Code</label>
                        <span>
                            <input required type="text" name="city" id="city" placeholder="City">
                            <input required type="number" min="0" name="zipcode" id="Zcode" placeholder="Zip code">
                        </span>

                        <label for="Country_state">Country & State</label>
                        <span>
                            <select required name="country_id" class="country">
                                <option value="" selected>Country</option>
                                @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>

                            <select required name="state_id" class="country">
                                <option value="" selected>Select State</option>
                            </select>
                            <!-- <input required type="text" name="state" id="state" placeholder="state"> -->
                        </span>
                    </div>

                    <h5>Contact Information</h5>
                    <span id="contacts"></span>
                    <h5><a onClick="addContact()">Add other contacts &nbsp; +</a></h5>
                </div>
            </section>
            <!-- <section>
                <button class="btn">NEXT</button>
            </section> -->
    </main>

    <button class="btn" id="step4LowerButton" type="submit">NEXT</button>
    </div>

    </div>
</form>
@endsection

@section('script')

<script type="text/javascript">
    //use jquery to handle next buttons
    $("#step4UpperButton").on("click", function() {
        $("#step4LowerButton").trigger("click");
    });

    $("#moveBack").on("click", function() {
        window.history.back();

    });

    $("#Cname").on("input", function() {
        $("#step4UpperButton").css("background-color", "#0ABAB5");
        $("#step4LowerButton").css("background-color", "#0ABAB5");
    });

    //handle form close
    $("#closeForm").on("click", function() {
        let path = "@php echo session("
        path ") @endphp";
        window.location = path;

    });

    let count = 1;
    window.addEventListener('load', function() {
        addContact();
    })

    function addContact() {
        let element = document.querySelector('#contacts')
        let newElement = document.createElement('div');
        newElement.classList.add('form-group');
        newElement.innerHTML = `
            <label for="company_name_${count}">Contact name</label>
            <input type="text" name="contact[${count}]['name']" id="contact_name${count}" placeholder="e.g Ben Davies">

            <label for="company_email">Contact email</label>
            <input type="email" name="contact[${count}]['email']" id="email_${count}" placeholder="e.g email@domain.com">
        `;
        element.appendChild(newElement);
        count += 1;
    }

    $(document).ready(function() {
        $('select[name="country_id"]').on('change', function() {
            let countryID = $(this).val();
            if (countryID) {
                $.ajax({
                    url: '/states/' + encodeURI(countryID),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="state_id"]').empty();
                        $('select[name="state_id"]').append('<option selected value="">Select State</option>');
                        $.each(data.data, function(key, value) {
                            $('select[name="state_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('select[name="state"]').empty();
            }
        });
    });
</script>
@endsection
