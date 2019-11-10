<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet'>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- Fontawesome CSS -->
	    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
	    
		<title>Payment for {{$data['name']}}</title>
        <link rel="shortcut icon" href="https://res.cloudinary.com/ddu0ww15f/image/upload/c_scale,h_16/v1571841777/icons8-home-office-24_veiqea.png" type="image/x-icon">
        
        <!--Internal CSS Starts -->

        <style>

            :root{
				--primary-color: #091429;
				--secondary-color: #0ABAB5;
				--dark-color: #262626;
				--light-color: #B1B1B1;
			    }
            .btn-secondary {
                background-color: var(--secondary-color) !important;
                color:white;
            }


            /* logo styling */
            .logo{
            font-size: 36px;
            font-family: 'pacifico', Ubuntu;
            display: block;
            text-align: left;
            padding-left: 40px;
            margin-top: 20px;
            }

            .logo a{
            text-decoration: none;
            color:#000;
            }

            .logo span {
            color: #0abab5;
            }

            /* styling for content  */

            .box{
                /* width: 50vw; */
                height: 40vh!important;
                margin: 5vh auto;
                padding: 3%;
                background-color:#091429;
                color:aliceblue;
                /*box-shadow: 0px 2px 5px 2px #c0bcbc;*/
                border-radius: 15px;
                font-family: 'ubuntu';

            }

            .btn1{
                height: 5vh;
                /* margin-left: 14.5vw; */
                margin-top: 3vh;
                border-radius: 6px;
                /*box-shadow: 0px 2px 2px #6d6b6b;*/
                border:none;
            }

            #plans{
                border-radius: 6px;
                height: 5vh;
                width: 15vw;
            }

            .case{
                display: grid;
                grid-template-columns: 1fr 1fr;
            }

            .select{
                /* margin-left: 0px!important; */
            }

            
            /*-----------footer list--------*/
			.list-unstyled li a{
				font-size: 17px !important;
				transition: 0.25s !important;
				font-style: normal;
				font-weight: normal;
			}
			.list-unstyled li a:hover{
				color: gray !important;
				text-decoration: none;
			}

            .enter-div {
                text-align: center;
                color: white;
                font-weight: normal;
                font-style: normal;
            }

            .enter-div > h6 {
                font-weight: normal;
            }

            #enter-line {
                line-height: 65px;
            }

            #lancer {

            font-style: normal;
            font-weight: normal;
            font-family: 'Pacifico', cursive;
            font-size: 20px;
            }

            #btn-sub {
                background: #0ABAB5;
                border-radius: 4px;
                border-width: 0px;
                color: #FFFFFF;
            }

            #email-input {
                background: #FFFFFF;
                border: 1px solid #C4C4C4;
                box-sizing: border-box;
                border-radius: 2px;
                color: black;
                font-size: 0.8em;
                padding: 5px;
                }

            .btn {
                border: 1px solid #0ABAB5 ;
                
                box-sizing: border-box;
                border-radius: 6px;
                }

            .link {
                color: black;
            }

            .card {
                background: #FFFFFF;
                border: none;
                width: 350px !important;
                max-width: 350px !important;
                margin-right: auto;
                margin-left: auto;
            }

            ul {
                padding: 0% !important;
            }
            
            #btn-sub:hover {
                background-color: rgb(9, 155, 150);
            }
            
            #navbarNavAltMarkup a:hover {
                color: #0ABAB5 !important;
            }

            span.avoidwrap { display:inline-block; }

            .foot{
                border-top: 2px solid rgb(204, 198, 198);
                margin-top: 10vh!important;
            }

 /* =============MEDIA QUERIES============ */

            @media screen and (max-width: 360px){
                .box{
                    width: 90%!important;

                }
                    p{
                        font-size: 24px!important;
                        padding: 2%;
                    }

                .select{
                    margin-left: 0px!important;
                    padding-left: 0px!important;
                    padding-right: 20%!important;

                }

                
            }

            @media screen and (max-width: 482px){
                .box{
                    width: 90%!important;
                }

                p{
                        font-size: 24px!important;
                        padding-top: 2%;
                    }

                .select{
                    margin-left: 0px!important;
                    padding-left: 5px!important;
                    /* padding-right: 5%!important; */
                    width: 30vw!important;
                

                }

                .selectPlan{
                    margin-left: 30%!important;
                }

            }

            @media screen and (max-width: 769px){

                .box{
                    width: 90%!important;
                }

                .select{
                    margin-left: 0px!important;
                    padding-left: 5px!important;
                    /* padding-right: 5%!important; */
                    width: 25vw!important;
                

                }

            }

            

            @media screen and (max-width: 575px){
                
                .foot-container{
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                }
               
            }

            @media screen and (max-width: 482px){
                
                .foot-container{
                    display: grid;
                    grid-template-columns: 1fr;
                    margin-left: 5%;
                    margin-right: 5%;
                }
               
            }

            
        
        </style>

    </head>

    <body>

        <div class="logo"> <a href="https://lancers.app/"> Lan<span>c</span>ers </a></div><br>
        <div class="container">
            <div class="box w-75 h-25 border">
                <p class=" h2 text-center">Payment for {{$data['name']}}</p>
                <div class="form mt-3">
                     @if($data['type'] == 'sub')
                            <fieldset>
                                <legend></legend>
                                <div class="case w-75 mx-auto mt-5">
                                    <div class="select ml-3 pl-3 mr-2">Enter number of months:</div>
                                    <div class="selectPlan ml-4">
                                        <input id="months_input" min="1" type="number" class="form-control" value="1" autofocus>

                                        <button id="makepayment" class="btn-secondary btn1 btn-block">Pay NGN{{number_format((float)($data['amount'] * 350), 2)}}</button>

                                    </div>
                                    
                                </div>
                            </fieldset>
                        @else
                            <div class="col-md-6 offset-md-3">
                                <br>
                                <button id="pay_default" class="btn-secondary btn1 btn-block">Pay NGN{{number_format((float)$data['amount'], 2)}}</button>
                            </div>
                        @endif
                </div>
                
            </div>
        </div>



        
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

                    <script src="https://js.paystack.co/v1/inline.js"></script>
            <script>
                const paymentType = "{{$data['type']}}";
                window.addEventListener('DOMContentLoaded', function () {              
                    const monthsInput = document.getElementById("months_input");
                    const makePaymentBtn = document.getElementById("makepayment");
                    const payDefault = document.getElementById("pay_default");
                    const dbAmount = Number({{$data['amount']}});

                    if(paymentType == "sub"){    
                        const balance = new Number({{$data['balance']}})                    
                        monthsInput.addEventListener("input", function(e){
                            makePaymentBtn.innerText = "Pay NGN" + formatNumber(((e.target.value * dbAmount * 350) - balance).toFixed(2));
                        });

                        makePaymentBtn.addEventListener('click', function(){
                            let months = monthsInput.value;
                            let amount = (months * dbAmount) - balance;

                            if(months < 1){
                                alert("Number of months must be at least 1");
                            }else{
                                payWithPaystack(amount*350, months);
                            }
                        });
                    }else{                        
                        payDefault.addEventListener('click', function(){
                            payWithPaystack(dbAmount);
                        });
                    }



                });


                const API_publicKey = "{{$data['key']}}";
                const redirect = "{{$data['redirect']}}";

                function payWithPaystack(amount, months = 1){
                    var handler = PaystackPop.setup({
                      key: API_publicKey,
                      email: "{{auth()->user()->email}}",
                      amount: amount*100,
                      currency: "NGN",
                      ref: "{{$data['ref']}}",
                      metadata: {
                         custom_fields: [
                            {
                                display_name: "type",
                                variable_name: "type",
                                value: "{{$data['type']}}"
                            },
                            {
                                display_name: "id",
                                variable_name: "id",
                                value: "{{$data['id']}}"
                            },
                            {
                                display_name: "months",
                                variable_name: "months",
                                value: months
                            }
                         ]
                      },
                      callback: function(response){
                          window.location.href = redirect +  response.reference;
                      },
                      onClose: function(){
                          // alert('Transaction has ended');
                      }
                    });
                    handler.openIframe();
                }
                function formatNumber(num) {
                  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                }
            </script>
    </body>
</html>