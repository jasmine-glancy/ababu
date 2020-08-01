@extends('layouts.app')

@section('content')
<style>
    .btn-group-xs>.btn,
    .btn-xs {
        padding: .25rem .4rem;
        font-size: .875rem;
        line-height: .5;
        border-radius: .2rem;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{__('translate.owners')}}<br>
                    <small>{{ __('help.owners_description') }}</small>
                    <button type="button" id="btnNew" class="btn btn-sm btn-primary">{{__('translate.new')}}</button>
                    <button type="button" id="btnEdit" class="btn btn-sm btn-secondary"
                        disabled>{{__('translate.edit')}}</button>
                    <button type="button" id="btnDelete" class="btn btn-sm btn-danger"
                        disabled>{{__('translate.delete')}}</button>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col col-md-12">
                            <table id="owners" class="display compact" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('translate.firstname')}}</th>
                                        <th>{{__('translate.lastname')}}</th>
                                        <th>{{__('translate.address')}}</th>
                                        <th>{{__('translate.postcode')}}</th>
                                        <th>{{__('translate.city')}}</th>
                                        <th>{{__('translate.phone')}}</th>
                                        <th>{{__('translate.mobile')}}</th>
                                        <th>{{__('translate.email')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- first row detail -->
                    <div class="row">
                        <div class="col col-md-12">
                            <h5>placeholder</h5>
                            <table id="pets" class="display compact" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('translate.name')}}</th>
                                        <th>{{__('translate.gender')}}</th>
                                        <th>{{__('translate.description')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

@if( Auth::user()->hasAnyRolesByClinicId(['admin', 'veterinarian'], $clinic->id) )
@include('clinics.modal.edit')
@include('clinics.modal.invite')
@include('clinics.modal.confirm-delete')
@endif

@endsection

@push('scripts')
@if( Auth::user()->hasAnyRolesByClinicId(['admin', 'veterinarian'], $clinic->id) )
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">

<script type="text/javascript">
    $(function() {
        var table = $('#owners').DataTable({
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: "{{ route('clinics.owners.list', 0) }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'firstname', name: 'firstname'},
                {data: 'lastname', name: 'lastname'},
                {data: 'address', name: 'address'},
                {data: 'postcode', name: 'postcode'},
                {data: 'city', name: 'city' },
                {data: 'phone', name: 'phone'},
                {data: 'mobile', name: 'mobile'},
                {data: 'email', name: 'email', 
                render: function(data, type, row, meta){
                        if(type === 'display'){
                            data = '<a href=mailto:"' + data + '">' + data + '</a>';
                        }
                        return data;
                    }
                },
            ],
            columnDefs: [
                {targets: 0, "width": "1%"},
                {targets: 3, "width": "150px"},
            ]
        } );

        var table_pets = $('#pets').DataTable( {
		//"ajax": "/ajax/objects.txt",
            data : [],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'gender', name: 'gender'},
                {data: 'description', name: 'description'},
            ]
	    } );

        $('#owners tbody').on('click', 'tr', function() {
            var rowData = table.row(this).data();
            console.log(rowData.id)
            table_pets.ajax.url("/clinics/{{$clinic->id}}/owners/" + rowData.id + "/pets/list").load();
            
            
            if ($(this).hasClass('selected')) {
                // $(this).removeClass('selected');
            } else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }

            $('#btnEdit').prop('disabled', false);
            $('#btnVisit').prop('disabled', false);
            $('#btnDelete').prop('disabled', false);
        });


        $('#btnEdit').click(function() {
            var selData = table.rows(".selected").data();
            console.log('io: ' + selData[0].id);
            console.log(table_pets);
        });
    });

    


    $(document).on('click', '.open_modal_edit', function() {
        $('#edit-modal').modal('show');
    });

    $(document).on('click', '.open_modal_invite', function() {
        $('#invite-modal').modal('show');
    });

    $(document).on('click', '.open_modal_delete', function() {
        $('#confirm-delete-modal').modal('show');
    });
</script>
@endif
@endpush