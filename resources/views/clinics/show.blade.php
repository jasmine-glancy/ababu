@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{__('translate.Clinic')}} {{ $clinic->name }}
                    @if( Auth::user()->hasRoleByClinicId('admin', $clinic->id) )
                    <a href="{{ route('clinics.edit', $clinic) }}" class="btn btn-sm btn-primary">{{__('translate.edit')}}</a>
                    @endif
                    <br>
                    <small>{{$clinic->description}}</small>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <h5>Quick Links</h5>
                    <ul>
                        <li><a href="#">{{__('translate.Pets')}}</a></li>
                        @can('admin', $clinic)
                        <li><a href="{{route('clinics.users.list', $clinic)}}">{{__('translate.Users')}}</a></li>
                        @endcan
                        <li><a href="#">{{__('translate.Visits')}}</a></li>
                        <li><a href="#">{{__('translate.Owners')}}</a></li>
                        <li><a href="#">{{__('translate.Calendar')}}</a></li>
                    </ul>



                    clinic dashboard


                </div>
            </div>


        </div>
    </div>
</div>
@endsection