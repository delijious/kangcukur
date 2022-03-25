@extends('layouts.app')
@section('content')

@include('layouts.top-header', [
    'title' => __('View') ,
    'headerData' => __('Refund') ,
    'url' => 'admin/users' ,
    'class' => 'col-lg-7'
])


<section class="section">
    @if (Session::has('msg'))
    <script>
         var msg = "<?php echo Session::get('msg'); ?>"
        $(window).on('load', function()
        {
            iziToast.success({
                message: msg,
                position: 'topRight'
            });
            console.log(msg);
    });
    </script>
    @endif
    <div class="container-fluid mt--6 mb-5">
        <div class="row">
            <div class="col">
                <div class="card">
                <div class="card-header border-0">
                    <span class="h3">{{__('Refund Management')}}</span>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center " id="dataTable" class="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th></th>
                                <th scope="col" class="sort">{{__('Order Id')}}</th>
                                <th scope="col" class="sort">{{__('User Name')}}</th>
                                <th scope="col" class="sort">{{__('User Bank Details')}}</th>
                                <th scope="col" class="sort">{{__('Refund Reason')}}</th>
                                <th scope="col" class="sort">{{__('Refund Amount')}}</th>
                                <th scope="col" class="sort">{{__('Refund Status')}}</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($refunds as $refund)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $refund->order['order_id'] }}</td>
                                <td>{{ $refund->user['name'] }}</td>
                                <td>
                                    <a href="" onclick="user_bank_details({{$refund->user_id}})" data-toggle="modal" data-target="#view_order">{{__('User bank Details')}}</a>
                                </td>
                                <td>{{ $refund->refund_reason }}</td>
                                <td>{{ $currency }}{{ $refund->order['amount'] }}</td>
                                <td>
                                    <select name="refundStatus" onchange="refundStatus({{$refund->id}})" id={{$refund->id}} class="form-control" {{ $refund->refund_status != 'PENDING' ? 'disabled' : '' }}>
                                        <option value="{{'PENDING'}}" {{ $refund->refund_status == 'PENDING' ? 'selected' : '' }}>{{__('Pending')}}</option>
                                        <option value="{{'ACCEPT'}}" {{ $refund->refund_status == 'ACCEPT' ? 'selected' : '' }}>{{__('Accept')}}</option>
                                        <option value="{{'CANCEL'}}" {{ $refund->refund_status == 'CANCEL' ? 'selected' : '' }}>{{__('Cancel')}}</option>
                                        <option value="{{'COMPLETE'}}" {{ $refund->refund_status == 'COMPLETE' ? 'selected' : '' }}>{{__('Complete')}}</option>
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
 <div class="modal right fade" id="view_order" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="staticBackdropLabel">{{__('User bank Details')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    {{-- <h4 class="user_name">{{__('user name')}}</h4> --}}
                    <tr>
                        <th>{{__('user name')}}</th>
                        <td class="user_name"></td>
                    </tr>
                    <tr>
                        <th>{{__('Ifsc Code')}}</th>
                        <td class="ifsc_code"></td>
                    </tr>

                    <tr>
                        <th>{{__('Account name')}}</th>
                        <td class="account_name"></td>
                    </tr>

                    <tr>
                        <th>{{__('Account number')}}</th>
                        <td class="account_number"></td>
                    </tr>

                    <tr>
                        <th>{{__('MICR code')}}</th>
                        <td class="micr_code"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection
