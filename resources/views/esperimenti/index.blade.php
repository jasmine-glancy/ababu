@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Esperimenti
                        <br>
                        <small>das ist untervallen</small>
                    </div>
                    <div class="float-end">
                        <a href="{{ route('home') }}" class="btn btn-sm btn-primary">{{__('home')}}</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    here are some experiments [body]




                </div>
            </div>
        </div>
    </div>
</div>
@endsection
