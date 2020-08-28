<style>
    .vertical-scroll {
        height: 150px;
        overflow-y: scroll;
    }

    td {
        border: 1px #DDD solid;
        padding: 5px;
        cursor: pointer;
    }

    .selected {
        background-color: lightseagreen;
        color: #FFF;
    }


    #problems tr>*:nth-child(1) {
        display: none;
    }

    #problems td {
        border-left: none;
        border-right: none;
    }
</style>
<div class="row">
    <div class="col-12">
        <!-- owner -->
        <div class="row">
            <div class="col-md-12">
                <select id="diagnosis_id" name="diagnosis_id"></select>
                @error('problem_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 vertical-scroll">
        <table id="problems" border="0" style="width:100%">
            <!--
            <thead>
                <tr>
                    <th>#</th>
                    <th>#</th>
                    <th>#</th>
                    <th>{{__('translate.description')}}</th>
                    <th>#</th>
                </tr>
            </thead>
        -->
            <tbody>
                @foreach ($problems as $problem)

                <tr>
                    <td>{{ $problem->id }}</td>
                    <td><img title="{{ __('translate.' . $problem->statuses[$problem->status_id]) }}"
                            src="{{url('/images/icons/problem_status_' . $problem->status_id . '.png')}}"></td>
                    <td>{{ $problem->diagnosis_id }}</td>
                    <td>{{ $problem->diagnosis->term_name }}</td>
                    <td>
                        @if( $problem->key_problem == true )
                        <img title="{{ __('translate.problem_key_problem') }}"
                            src="{{url('/images/icons/problem_key_problem.png')}}">
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('problems.modal.edit')
@push('scripts')
<!-- select2 -->
<script type="text/javascript" src="{{url('/lib/select2-4.1.0-beta.1/dist/js/select2.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{url('/lib/select2-4.1.0-beta.1/dist/css/select2.min.css')}}" />


<script type="text/javascript">
    $(function() {
        $("#problems tr").click(function(){
            $(this).addClass('selected').siblings().removeClass('selected');    
            /*
            var value=$(this).find('td:first').html();
            alert(value);
            */    
            problem_id = $(this).find('td:first').html();
            diagnosis_id = $(this).find('td:eq(1)').html();
        });

        // problem table double click
        $("#problems tr").dblclick(function(){
            // todo: delete me ?
            // problem_id = $(this).find('td:first').html();
            diagnosis_id = $(this).find('td:eq(2)').html();

            openProblemEditModal(diagnosis_id);
        });

        $("#diagnosis_id").select2({
            ajax: { 
                placeholder: "Choose owner...",
                minimumInputLength: 3,
                url: "/diagnoses/search/",
                dataType: "json",
                dropdownAutoWidth : true,
                data: function (params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $("#diagnosis_id").on("change", function(e) { 
            // what you would like to happen
            // console.log(e);
            console.log("diagnosis_id: " + $("#diagnosis_id").val());


            openProblemEditModal($("#diagnosis_id").val());

        });
    
    })


    function openProblemEditModal(diagnosis_id)
    {
        $.ajax({
            url: '/clinics/{{$clinic->id}}/problem/diagnosis/' + diagnosis_id + '/pet/{{$pet->id}}',
            type: 'get',
            success: function(problem)
            {
                console.log("problem: " + problem);
                // fill Modal with owner details                    

                $('#problem-edit-active_from').val(problem.active_from);
                $('#problem-edit-active_from').datepicker('update');


                // $('#problem-edit-id').val(problem.id);
                $('#problem-edit-diagnosis_id').val(problem.diagnosis_id);
                $('#problem-edit-diagnosis_term_name').val(problem.diagnosis.term_name);
                $('#problem-edit-subjective_analysis').val(problem.subjective_analysis);
                $('#problem-edit-objective_analysis').val(problem.objective_analysis);
                $('#problem-edit-notes').val(problem.notes);

                console.log("problem.status_id: " + problem.status_id);
                
                $('#problem-edit-status_id_' + problem.status_id).prop("checked", true);
                $('#problem-edit-key_problem').prop("checked", problem.key_problem == 1 ? true : false);
                

                // calculate "At Age"
                setAtAge();

                // Set action and method
                if(problem.id > 0){
                    $('#problem-edit-modal-form').attr('action', '/clinics/{{$clinic->id}}/problems/' + problem.id);
                    $('[name="_method"]').val('PUT');
                }else{
                    $('#problem-edit-modal-form').attr('action', '/clinics/{{$clinic->id}}/problems');
                    $('[name="_method"]').val('POST');
                }
                console.log( $('[name="_method"]').val() );

                // Display Modal
                $('#problem-edit-modal').modal('show');
            }
        });
    }


    

</script>
@endpush