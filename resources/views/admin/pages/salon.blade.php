@extends('layouts.app')
@section('content')

@include('layouts.top-header', [
        'title' => __('Salon') ,
        'class' => 'col-lg-7'
    ])


<div class="container-fluid mt--6 mb-5 only_search">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header border-0">
            <span class="h3">{{__('Salon table')}}</span>
          </div>
          <div class="table-responsive">
            <table class="table align-items-center table-flush"  id="dataTableUser">
              <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort">{{__('#')}}</th>
                    <th scope="col" class="sort">{{__('Image')}}</th>
                    <th scope="col" class="sort">{{__('Name')}}</th>
                    <th scope="col" class="sort">{{__('Owner name')}}</th>
                    <th scope="col" class="sort">{{__('Salon For')}}</th>
                    <th scope="col" class="sort">{{__('Created_at')}}</th>
                    <th scope="col" class="sort">{{__('Updated_at')}}</th>
                    <th scope="col" class="sort">{{__('Status')}}</th>
                    <th></th>
                </tr>
            </thead>
              <tbody class="list">
                    @foreach ($salons as $key => $salon)
                    <tr>
                            <th>{{$loop->iteration}}</th>
                            <td>
                                <img src="{{asset('storage/images/salon logos/'.$salon->image)}}" class="tableimage rounded">
                            </td>
                            <td>{{$salon->name}}</td>
                            <td>{{$salon->ownerName}}</td>
                            <td>{{$salon->gender}}</td>
                            <td>{{$salon->created_at}}</td>
                            <td>{{$salon->updated_at}}</td>
                            <td>
                              <label class="custom-toggle">
                                  <input type="checkbox"  onchange="hideSalon({{$salon->salon_id}})" {{$salon->status == 0?'checked': ''}}>
                                  <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Hide"></span>
                              </label>
                            </td>
                            <td class="table-actions">
                              @php
                                $base_url = url('/');
                              @endphp
                                <a href="{{url('admin/salons/'.$salon->salon_id)}}" class="table-action text-warning" data-toggle="tooltip" data-original-title="{{__('View Salon')}}">
                                      <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn-white btn shadow-none p-0 m-0 table-action text-danger bg-white" onclick="deleteData('admin/salons',{{$salon->salon_id}},'{{$base_url}}')" data-toggle="tooltip" data-original-title="{{__('Delete Salon')}}">
                                    <i class="fas fa-trash"></i>
                                </button>
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
@endsection