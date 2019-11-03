@extends('layouts.settings_email')

@section('main-content')
<div class="wrapper">
	<!-- Sidebar Holder -->

	<!-- Page Content Holder -->
	<div id="content">
			<section class="container-fluid">
					<div class="row mt-4 ml-auto mr-auto" id="overallMainContentWrapper">
							<div class="col-md-4 mt-4 pt-2 mb-4">
									<div class="card settingsNavDiv mt-4">
										 <div class="settingsNavDivImg">
												 <div class="text-center p-1"><img class="mt-2"  src="https://res.cloudinary.com/nxcloud/image/upload/v1571934958/Lancer/Lancers_1_xfqglr.svg" alt="Lancer Logo" width="100px"></div></div>
											<div class="card-body">
													<p class="text-center"><a href="/dashboard/profile/settings">Profile Settings</a></p>
													<p class="text-center"><a href="#" style="color: #0ABAB5;">Email Notification</a></p>
													<p class="text-center"><a href="/users/subscriptions">Subscription</a></p>
											</div>
									</div>
							</div>
							<div class="col">
									<div class="container-fluid">

											<div class="formSection mb-5" style="min-width: 90%">
													<div class="formsContainer mr-auto pt-2">
														 <p class="mt-0 text-primary font-weight-bold" style="font-size: 1.2em">EMAIL SETTINGS</p>

                            @if(($status == "success") && ($data != null ))

                                @php
                                $invoiceMessage = $data['auto_invoice_message'];
                                $proposalMessage = $data['auto_approval_message'];
                                $agreementMessage = $data['auto_agreement_message'];

                                @endphp
                        @endif

                        @if(($status == "failure") && ($data == null ))
                            @php
                            $invoiceMessage = '';
                            $proposalMessage = '';
                            $agreementMessage = '';

                            @endphp
                     @endif

                     @if(session('editErrors'))
                        <div class="alert alert-fail" role="alert">
                            <h5><strong>Error:</strong></h5>
                            @foreach(session('editErrors') as $error)
                                        <i style="color: red;">{{ $error }} </i></br>
                            @endforeach
                            </div>
                    @endif

                    @if(session('editSuccess') != null)
                    <div class="alert alert-fail" role="alert">
                        <h5><strong>Success:</strong></h5>

                        <i style="color: green;">{{ session('editSuccess') }} </i></br>

                        </div>
                    @endif

                    @if(session('editFailure') != null)
                    <div class="alert alert-fail" role="alert">
                        <h5><strong>Error:</strong></h5>

                        <i style="color: red;">{{ session('editFailure') }} </i></br>

                        </div>
                    @endif
                                                            <form class="card card-body mt-4" id="userInfoForm" method="POST" action="{{ route('SET-EMAIL') }}">
                                                            @csrf
                                                             @method('PUT')
                                                                 <div class="row pl-3 pr-4">
																		 <p class="card-title font-weight-bold  col" style="font-size: 1.3em">Set Your Default Auto Response Message</p>
																 <div class="text-center" id="add-something col">
																			<button class="btn btn-secondary text-white rounded-circle" >
																					<i class="fas fa-plus"></i>
																			</button>
																	</div>
																 </div>
																	<div class="row mt-3 pl-3 pr-3">
																			<div class="form-group formContainer col">
																					<label for="autoResponseOne" class="font-weight-bold">Auto Response Invoice Message</label>
																					<textarea rows="5" id="autoResponseOne" name="invoice" class="form-control mt-2" placeholder="Enter Auto Response" > {{ $invoiceMessage }}</textarea>
																			</div>
																	</div>

																	<div class="row mt-4 pl-3 pr-3">
																			<div class="form-group formContainer col">
																					<label for="autoResponseTwo" class="font-weight-bold">Auto Response Proposal Message</label>
																					<textarea rows="5" id="autoResponseTwo" name="proposal" class="form-control mt-2" placeholder="Enter Auto Response"> {{ $proposalMessage }}</textarea>
																			</div>
																	</div>

																	<div class="row mt-4 pl-3 pr-3">
																			<div class="form-group formContainer col">
																					<label for="autoResponseThree" class="font-weight-bold">Auto Response Agreement Message</label>
																					<textarea rows="5" id="autoResponseThree" name="agreement" class="form-control mt-2" placeholder="Enter Auto Response">{{ $agreementMessage }}	</textarea>
																			</div>
																	</div>

																	<div class="row"><button class="btn btn-primary  ml-auto mr-auto mt-4" id="updateButton">Update</button></div>

															</form>




														<!---	<form class="card card-body mt-4" id="defaultAutoMessage">
																 <p class="card-title font-weight-bold pl-3 pr-3" style="font-weight: bold">Default Auto Message</p>

																 <div class="form-check ml-3 mr-3 mt-2">
																		<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
																		<label class="form-check-label" for="exampleRadios1">
																			It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
																		</label>
																	</div>
																	<div class="form-check ml-3 mr-3 mt-2">
																		<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
																		<label class="form-check-label" for="exampleRadios2">
																			It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
																		</label>
																	</div>
																	<div class="form-check ml-3 mr-3 mt-2">
																		<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
																		<label class="form-check-label" for="exampleRadios2">
																			It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
																		</label>
																	</div>
																	<div class="form-check ml-3 mr-3 mt-2">
																		<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
																		<label class="form-check-label" for="exampleRadios2">
																			It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
																		</label>
																	</div>
																	<div class="form-check ml-3 mr-3 mt-2">
																		<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
																		<label class="form-check-label" for="exampleRadios2">
																			It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
																		</label>
																	</div>

<!--
																	<div class="row mt-3 pl-3 pr-3">
																			<div class="form-group formContainer col">
																					<label for="autoResponseOne" class="font-weight-bold">Auto Response Invoice Message</label>
																					<textarea rows="5" id="autoResponseOne" name="autoResponseOne" class="form-control mt-2" placeholder="Enter Auto Response" >It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution  It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more Thanks..</textarea>
																			</div>
																	</div>

																	<div class="row mt-4 pl-3 pr-3">
																			<div class="form-group formContainer col">
																					<label for="autoResponseTwo" class="font-weight-bold">Auto Response Invoice Message</label>
																					<textarea rows="5" id="autoResponseTwo" name="autoResponseTwo" class="form-control mt-2" placeholder="Enter Auto Response">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution  It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more Thanks..</textarea>
																			</div>
																	</div>

																	<div class="row mt-4 pl-3 pr-3">
																			<div class="form-group formContainer col">
																					<label for="autoResponseThree" class="font-weight-bold">Auto Response Invoice Message</label>
																					<textarea rows="5" id="autoResponseThree" name="autoResponseThree" class="form-control mt-2" placeholder="Enter Auto Response">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution  It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more Thanks..</textarea>
																			</div>
																	</div>


																	<div class="row"><button class="btn btn-primary  ml-auto mr-auto mt-4" id="updateButton">Update</button></div>

															</form> -->

<!--
															<form class="mt-5 card card-body" id="companyForm">
																	<div class="row">
																			<div class="form-group formContainer col-12 col-sm-6">
																					<label for="companyName">Company Name</label>
																					<input type="text" id="companyName" name="companyName" class="form-control" placeholder="Company Name"  />
																			</div>

																			<div class="form-group col-12 col-sm-6">
																					<label for="companyEmail">Company Email</label>
																					<input type="email" id="companyEmail" name="companyEmail" class="form-control" placeholder="foodie@gmail.com"  />
																			</div>
																	</div>

																	<p class="mb-4 mt-4" id="addressSettingToggle">
																		<a class="" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
																		<span class="up"><i class="fas fa-chevron-up"></i></span>
																		<span class="down"><i class="fas fa-chevron-down"></i></span> &nbsp; Address Setting</a>

																	</p>
																	<div class="row">
																		<div class="col">
																			<div class="collapse multi-collapse" id="multiCollapseExample2">
																					 <div class="row">
																							 <div class="form-group col">
																									<label for="companyAddress">Company Address</label>
																									<input type="text" id="companyAddress" name="companyAddress" class="form-control" placeholder=""  />
																							</div>
																					 </div>
																				<div class="row">
																					<div class="form-group col-12 col-sm-6">
																							<label for="state">State</label>
																							<input type="" id="state" name="state" class="form-control" placeholder="State" />
																					</div>

																					<div class="form-group col-12 col-sm-6">
																							<label for="country">Country</label>
																							<input type="" id="country" name="country" class="form-control" placeholder="Country"/>
																					</div>
																			</div>

																			<div class="row">
																					<div class="form-group col-12 col-sm-6">
																							<label for="currency">Currency</label>
																							<input type="" id="currency" name="currency" class="form-control" placeholder="Currency" />
																					</div>

																					<div class="form-group col-12 col-sm-6">
																							<label for="timeZone">Time Zone</label>
																							<input type="" id="timeZone" name="timeZone" class="form-control" placeholder="Time Zone"/>
																					</div>
																			</div>
																			</div>
																		</div>

																	</div>

																	<div class="row"><button class="btn btn-primary  ml-auto mr-auto mt-4" id="updateButton">Update</button></div>
															</form>
-->


													</div>
											</div>
									</div>
							</div>
					</div>
			</section>
	</div>

</div>
@endsection
