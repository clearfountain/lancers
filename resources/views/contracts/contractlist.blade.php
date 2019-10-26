@extends('layouts.auth')

@section('main-content')
        <div class="content">
        <!---------Body Content------------>
        <a href="/add/client" class="createContract">Create contract</a>
        <h3>CONTRACT</h3>
        <p class="all">
            <label for="allContractList"></label>
            <select name="contractList" class="allContractList" id="contractList" style="border-radius: 5px;">
                <option value="1">All</option>
                <option value="2">NULL</option>
                <option value="3">NULL</option>
                <option value="4">NULL</option>
                <option value="5">NULL</option>
            </select>
        </p>
        @if(count($contracts) > 0)
            <table class="table">
                <tr align="left" class="thead">
                    <th>contracts</th>
                    <th>Client</th>
                    <th>Project</th>
                    <th>Issued</th>
                    <th>Status</th>
                </tr>
                    <?php $count = 1 ?>
                    @foreach($contracts as $key => $contract)
                        <tr class="border single-contract" style="cursor: pointer;" data-contract="{{$contract->contract->id}}">
                            <td>
                                <p>{{$count++}}</p>
                            </td>

                            <td>
                                <p>{{$contract->client->name}}</p>
                            </td>

                            <td>
                                <p>{{$contract->title}}</p>
                            </td>

                            <td>
                                <p>{{$contract->contract->issue_date == null ? dateSlash($contract->contract->created_at) : dateSlash($contract->contract->issue_date)}}</p>
                            </td>

                            <td>
                                @if($contract->contract->status == 'complete')
                                    <p class="statuscomplete">Complete</p>
                                @else
                                    <p class="statuspending">Pending</p>
                                @endif
                            </td>
                            
                            {{--<td>
                                <a href="">
                                    <i class="fa fa-ellipsis-v"></i>
                                </a>
                            </td> --}}
                        </tr>
                    @endforeach

            </table>
        @else
            <p class="text-center">No contracts to show</p>
        @endif
    </div>				
@endsection

@section('script')
	<script type="text/javascript">
		$(".single-contract").click(function(e){
			window.location.href = "/contracts/" + e.currentTarget.dataset.contract
		});
	</script>
@endsection

@push('styles')
	<style type="text/css">

	/*=========================Content Body Area ==================================*/
	.content {
		margin-top: 50px;
		padding: 10px;
	}

	.createContract {
		background: #0ABAB5;
		border: 1px solid #999999;
		box-sizing: border-box;
		font-size: 1.5em;
		font-weight: bold;
		font-family: 'Ubuntu', sans-serif;
		text-decoration: none;
		padding: 15px 15px;
		color: white;
		margin-left: 4%;
		border-radius: 5px;
	}

	h3 {
		font-family: 'Open Sans', sans-serif;
		font-weight: bold;
		font-size: 1.2em;
		margin-left: 4%;
		margin-top: 40px;
	}

	.all {
		margin-top: 30px;
		margin-bottom: 30px;
		margin-left: 4%;
	}

	.all select option {
		padding-top: 10px;
		font-size: 14px;
		line-height: 19px;
	}

	.allContractList {
		width: 20%;
		padding: 10px;
		border: 1px solid #C4C4C4;
		font-size: 14px;
		line-height: 19px;
	}

	.table {
		width: 95%;
		margin-top: ;
		border-collapse: collapse;
		margin-left: 4%;
	}

	.thead {
		font-weight: bold;
		font-size: 1.1em;
		line-height: 25px;
	}

	tr.border {
		border: 1px solid #C4C4C4;
		padding: 5px;
	}

	tr td:first-child{
		padding-left: 15px;
	}
	tr td:last-child{
		padding-right: 15px;
	}

	tr td p{
		margin-bottom: 0;
	}

	.border td {
		padding: 15px 0px;
		font-size: 14px;
		line-height: 16px;
	}

	.statuscomplete {
		width: 38%;
		padding: 5px 5px;
		border-radius: 4px;
		background-color: rgba(23, 150, 21, 0.1);
		color: #179615;
		font-weight: bold;
		text-align: center;
	}

	.statuspending {
		width: 38%;
		padding: 5px 5px;
		background: rgba(0, 159, 255, 0.1);
		border-radius: 4px;
		color: #091429;
		font-weight: bold;
		text-align: center;
	}
	</style>
@endpush