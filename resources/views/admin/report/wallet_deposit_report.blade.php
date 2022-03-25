@extends('layouts.app')
@section('content')

@include('layouts.top-header', [
        'title' => __('Wallet Deposit Report'),
        'class' => 'col-lg-7'
    ])

<div class="container-fluid mt--6 mb-5">
    <div class="row">
        <div class="col">
            <div class="card">
            <div class="card-header border-0">
                <span class="h3">{{__('Wallet Deposit Report')}}</span>
            </div>
            <form action="{{url('/admin/report/wallet/deposit')}}" method="post" class="ml-4" id="filter_revene_form">
                @csrf
                <div class="row rtl-date-filter-row">
                    <div class="form-group col-3">
                        <input type="text" id="filter_date" value="{{$pass}}" name="filter_date" class="form-control" placeholder="{{__('-- Select Date --')}}">
                        
                        @if($errors->any())
                            <h4 class="text-center text-red mt-2">{{$errors->first()}}</h4>
                        @endif
                    </div>
                    <div class="form-group col-3">
                        <button type="submit" id="filter_btn" class="btn btn-primary rtl-date-filter-btn">{{ __('Apply') }}</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table align-items-center table-flush" id="dataTable" class="dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th scope="col" class="sort">{{__('User')}}</th>
                            <th scope="col" class="sort">{{__('Added By')}}</th>
                            <th scope="col" class="sort">{{__('Amount')}}</th>
                            <th scope="col" class="sort">{{__('Date')}}</th>
                            <th scope="col" class="sort">{{__('Payment Type')}}</th>
                            <th scope="col" class="sort">{{__('Payment Token')}}</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <th>
                                        {{ $transaction->user['name'] }}
                                        {{-- <a href="{{ url('admin/user/user_wallet/'.$transaction->user['id']) }}">{{ $transaction->user['name'] }}</a> --}}
                                    </th>
                                    <td>{{ $transaction->payment_details['added_by'] }}</td>
                                    <td>{{ $currency }}{{ $transaction->amount }}</td>
                                    <td>{{ $transaction->date }}</td>
                                    <td>{{ $transaction->payment_details['payment_type'] }}</td>
                                    <td>{{ $transaction->payment_details['payment_token'] }}</td>
                                </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection