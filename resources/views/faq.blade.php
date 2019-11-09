@extends('layouts.app')

@section('styles')

<style>
    .accordion {
        content: "+";
        background-color: #eee;
        color: #444;
        cursor: pointer;
        padding: 16px;
        width: 100%;
        text-align: left;
        border: none;
        outline: none;
        transition: 0.4s;
    }

    .active,
    .accordion:hover {
        background-color: #ccc;
        content: "-";
    }

    .panel {
        padding: 0 16px;
        background-color: white;
        display: none;
        overflow: hidden;
    }

    h1 {
        text-align: center;
        font-family: 'ubuntu', sans-serif;
        margin-top: 1rem;
        color: #00F9FF;
        text-shadow: 0 3px 3px rgba(57, 63, 72, 0.3);

    }

    .main {
        font-family: 'ubuntu', sans-serif;
        font-size: 16px;
    }

    .heading {
        font-size: 36px;
        font-family: "Pacifico", cursive;

        background: #f5f5f5;
        width: 40px;
        height: 40px;
        font-size: normal;
        margin-bottom: 1%;

        line-height: 63px;

        transition: all 0.6s cubic-bezier(0.945, 0.020, 0.270, 0.665);
    }

    header {
        padding: 0.5%;
        /* margin-bottom:3%; */
    }

    header {
        -webkit-box-shadow: 0 3px 5px rgba(57, 63, 72, 0.3);
        -moz-box-shadow: 0 3px 5px rgba(57, 63, 72, 0.3);
        box-shadow: 0 3px 5px rgba(57, 63, 72, 0.3);
    }

    /* .more{
                margin-left: 80%;
                font-size: 20px;
            }
            #second{
                margin-left: 91%;
            }
            #third{
                margin-left: 88%;
            }
            
            #fourth{
                margin-left: 88%;
            }
            #fifth{
                margin-left: 81%;
            }
            #sixth{
                margin-left: 87%;
            }
            #seventh{
                margin-left: 89%;
            } */
</style>
@endsection



@section('header')

<header>

    <div class="heading"><a href="/"><img src="https://res.cloudinary.com/nxcloud/image/upload/v1570984909/Lancer/Lancers_c40ozr.svg"></a> </div>
</header> @stop @section('content')
<div class="container">

    <h1> Frequently Asked Questions</h1>
    <div class="main m-4">

        <div class="case mb-2">

            <button class="accordion">Is Lancers free to use?</button>
            <div class="panel-body">
                <p> Lancers cost absolutely nothing at all, and it is 100% free and secured.</p>
            </div>

        </div>

        <div class="case mb-2">
            <button class="accordion">Is my data safe?</button>
            <div class="panel-body">
                <p>We protect your information by adhering to internationally recognised Information Security
                    best practices and standards. We take the security of your data very seriously and use
                    strict procedures to protect it . Once we have received your information, we will use strict
                    procedures and security features to try to prevent unauthorised access, loss or damage.
                </p>
            </div>

        </div>

        <div class="case mb-2">
            <button class="accordion">Why isnt my invoice sending?</button>
            <div class="panel-body">
                <p>
                    please ensure you have a stable internet connection as Lancers can only work online.
                </p>
            </div>

        </div>

        <div class="case mb-2">
            <button class="accordion">Is naira the only currency allowed?</button>
            <div class="panel-body">
                <p>Lancers is available for all nations, you can always select the currency you want to use.</p>
            </div>

        </div>

        <div class="case mb-2">
            <button class="accordion">How does it work?</button>
            <div class="panel-body">
                <p>Lancers has made it easier to estimate project by taking in the total amount of time, subcontactors, equipment and devices it will take to complete a project. </p>
            </div>

        </div>


        <div class="case mb-2">
            <button class="accordion">How do I generate an Estimate?</button>
            <div class="panel-body">
                <p>To generate an estimate, you will need to sign in with your account, click on generate estimate,
                    select a new project, input the required details, click on next, input your client information and
                    generate an invoice
                </p>
            </div>

        </div>



        <div class="case mb-2">
            <button class="accordion">Can I save invoice?</button>
            <div class="panel-body">
                <p>Yes, you can save, download or print your invoice. Lancers has also made it easier to send your invoice directly to your mail.</p>
            </div>


        </div>
    </div>


</div>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {},
      Tawk_LoadStart = new Date();
    (function() {
      var s1 = document.createElement("script"),
        s0 = document.getElementsByTagName("script")[0];
      s1.async = true;
      s1.src = 'https://embed.tawk.to/5dc11896e4c2fa4b6bda03bf/default';
      s1.charset = 'UTF-8';
      s1.setAttribute('crossorigin', '*');
      s0.parentNode.insertBefore(s1, s0);
    })();
  </script>
  <!--End of Tawk.to Script-->

@endsection
@section('scripts')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    var acc = document.getElementsByClassName("accordion");
    var i;
    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            /* Toggle between adding and removing the "active" class,
            to highlight the button that controls the panel */
            this.classList.toggle("active");
            /* Toggle between hiding and showing the active panel */
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>
@endsection
