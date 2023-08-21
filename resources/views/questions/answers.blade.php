@extends('layouts.master')


@section('css')

        <link rel="stylesheet" type="text/css"
        href="{{ asset('/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" type="text/css"
        href="{{ asset('/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" type="text/css"
        href="{{ asset('/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
        <link rel="stylesheet" type="text/css"
        href="{{ asset('/app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css') }}">
        <link rel="stylesheet" type="text/css"
        href="{{ asset('/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
        <link rel="stylesheet" type="text/css"
        href="{{ asset('/app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css') }}">

    <style>
        #status_correct:checked + .form-check-label{
        background-color: rgb(28, 146, 4);
        color:  white;
        padding: 1px 2px;
        border-radius: 5px;
    }
    
        #status_correct2:checked + .form-check-label {
        background-color: rgb(28, 146, 4);
        color:  white;
        padding: 1px 2px;
        border-radius: 5px;
    }

    #status_incorrect:checked + .form-check-label {
        background-color: rgb(182, 68, 68);
        color: white;
        padding: 1px 2px;
        border-radius: 5px;
    }

    #status_incorrect2:checked + .form-check-label {
        background-color: rgb(182, 68, 68);
        color: white;
        padding: 1px 2px;
        border-radius: 5px;
    }

    </style>
        

@endsection



@section('title')
    لوحة التحكم
@endsection



@section('content')

<button class="btn btn-outline-primary" style="display: none" onclick="msg_add()" id="position-top-start"></button>
<button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()" id="position-top-start_edit"></button>
<button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()"id="position-top-start_delete"></button>

@if (request()->route('id'))
    @php
        $question = DB::table('questions')->where('id', request()->route('id'))->first();
    @endphp
    <h1>إجابات  {{ $question->question }}</h1>
@else
    <h1>قائمة الإجابات</h1>
@endif


<br>

@can('اضافة الاجابات')
    

<a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">إضافة إجابة</a>
@endcan

<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">الإجابات</h4>
            </div>
            <div class="table-responsive">
                <table class="table yajra-datatable" id="yajra-datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الإجابة</th>
                            <th>الحالة</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




{{-- modal add --}}
<div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">إضافة إجابات</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_answer_form" class="invoice-repeater">
                    @csrf
                    <div data-repeater-list="answers">
                        <div data-repeater-item>
                            <div class="row d-flex align-items-end">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label style="font-size: 20px">الإجابة</label>

                                        <?php
                                        use App\Models\Question;
                                        use App\Models\Quiz;
                                    
                                        $question = Question::where('id', $id)->first();
                                        $quiz = Quiz::where('id', $question->quiz_id)->first();
                                    
                                        if ($quiz->input_type == "نص") {
                                    ?>
                                            <div class="form-group">
                                                <input type="text" placeholder="أدخل السؤال هنا" name="answer" id="answer" class="form-control" />
                                                <span id="answer_error" class="text-danger"></span>
                                            </div>
                                    <?php
                                        } else {
                                    ?>
                                            <div class="form-group">
                                                <input type="file" placeholder="أدخل السؤال هنا" name="answer" id="answer" class="form-control" />
                                                <span id="answer_error" class="text-danger"></span>
                                            </div>
                                    <?php
                                        }
                                    ?>
                                    

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="status_correct" value="1">
                                            <label class="form-check-label" for="status_correct">
                                                الإجابة صحيحة
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="status_incorrect" value="0">
                                            <label class="form-check-label" for="status_incorrect">
                                                الإجابة خاطئة
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                                            <i data-feather="x" class="mr-25"></i>
                                            <span>الغاء</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between">
                            <button class="btn btn-icon btn-primary" type="button" data-repeater-create>
                                <i data-feather="plus" class="mr-25"></i>
                                <span>إضافة إجابة آخر</span>
                            </button>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" style="display: none" id="add_answer2" class="btn btn-primary btn-block">جاري الإضافة ...</button>
                <button type="button" id="add_answer" class="btn btn-primary btn-block">إضافة</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>

{{-- edit answer --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="edit_answer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">تعديل المرحلة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_answer_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-9">
                                <input type="hidden" name="id" id="id2">
                                <label style="font-size:18px">إسم القسم</label>
                                <div class="form-group">
                                    <?php

                                
                                        if ($quiz->input_type == "نص") {
                                            $placeholder = "أدخل الاجابة هنا";
                                            $inputType = "text";
                                            $answer_id = "answer2"; 
                                            
                                        } else {
                                            $placeholder = "أدخل الاجابة هنا";
                                            $inputType = "file";
                                            $answer_id = "answer3"; 
                                        }

                                        echo '<div class="form-group">';
                                        echo '<input type="' . $inputType . '" placeholder="' . $placeholder . '" name="answer" id="'.$answer_id.'" class="form-control" />';
                                        echo '<span id="answer_error" class="text-danger"></span>';
                                        echo '</div>';
                                        ?>
                                    {{-- <input type="text" placeholder="answer" name="answer" id="answer2" class="form-control" />
                                    <span id="answer2_error" class="text-danger"></span> --}}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" style="margin-top: 28px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_correct2" value="1">
                                        <label class="form-check-label" for="status_correct">
                                            الإجابة صحيحة
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_incorrect2" value="0">
                                        <label class="form-check-label" for="status_incorrect">
                                            الإجابة خاطئة
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="editing2" class="btn btn-primary btn-block">جاري التعديل...</button>
                        <button type="button" id="editing" onclick="do_update()" class="btn btn-primary btn-block">تعديل</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    {{-- delete answer --}}
    <div class="modal fade modal-danger text-left" id="delete_answer" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel120">حذف المرحلة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="delete_answer_form">
                        @csrf
                        <input type="hidden" name="id" id="id3">
                        هل انت متأكد من عملية الحذف ؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="delete_answer2" style="display: none"
                        data-dismiss="modal">...يتم الحذف</button>
                    <button type="button" class="btn btn-danger" onclick="do_delete()" id="delete_answer_button"
                        data-dismiss="modal">تأكيد</button>
                </div>
                </form>
            </div>
        </div>
    </div>



@endsection


@section('scripts')

<script>
    function msg_add() {

        Swal.fire({
            position: 'top-start',
            icon: 'success',
            title: 'تمت إضافة المرحلة بنجاح',
            showConfirmButton: false,
            timer: 1500,
            customClass: {
                confirmButton: 'btn btn-danger'
            },
            buttonsStyling: false

        });

    }

    function msg_edit() {

        Swal.fire({
            position: 'top-start',
            icon: 'success',
            title: 'تمت التعديل بنجاح',
            showConfirmButton: false,
            timer: 1500,
            customClass: {
                confirmButton: 'btn btn-danger'
            },
            buttonsStyling: false

        });

    }


    function msg_delete() {

Swal.fire({
    position: 'top-start',
    icon: 'success',
    title: 'تمت الحذف بنجاح',
    showConfirmButton: false,
    timer: 1500,
    customClass: {
        confirmButton: 'btn btn-danger'
    },
    buttonsStyling: false

});

}

</script>

<script type="text/javascript">
    $(function() {
        var table = $('#yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            @if(isset($id))
                 ajax: "{{ route('get_answers_data',$id) }}",
            @else
            
                 ajax: "{{ route('get_answers_data') }}",
            @endif
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {data: 'answer', name: 'answer'},
                {data: 'status', name: 'status'},
                {data: 'action'},
            ],

            "lengthMenu": [
                [5, 25, 50, -1], [5, 25, 50, 'All'] 
            ], // page length options
        });
    });
</script>



<script>
    $(document).on('click', '#add_answer', function(e) {
        $('#answer_error').text('');



        $("#add_answer2").css("display", "block");
        $("#add_answer").css("display", "none");
        var formData = new FormData($('#add_answer_form')[0]);
        $.ajax({
            type: 'post',
            enctype: 'multipart/form-data',
            url: "{{ route('store_answer', ['id' => $id])   }}",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                $('.yajra-datatable').DataTable().ajax.reload(null, false);
                // $('.yajra-datatable1').DataTable().ajax.reload(null, false);
                $("#add_answer2").css("display", "none");
                $("#add_answer").css("display", "block");
                $('.close').click();
                $('#position-top-start').click(); 
                $('#answer').val('');
            },
            
            error: function(reject) {
                $("#add_answer2").css("display", "none");
                $("#add_answer").css("display", "block");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });
    });
</script>


{{-- show edit answer --}}
<script>
    $(document).ready(function() {
        $('#edit_answer').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var answer = button.data('answer');
            var status = button.data('status');
            
            var modal = $(this);
            modal.find('.modal-body #id2').val(id);
            if (modal.find('#answer2')) {
                modal.find('.modal-body #answer2').val(answer);
            } else {
                modal.find('.modal-body #answer3').val(answer);
            }
            modal.find('.modal-body #status_correct2').prop('checked', status === 1);
            modal.find('.modal-body #status_incorrect2').prop('checked', status === 0);
        });
    });
</script>


    {{-- update answer --}}
    <script>
        function do_update(){
    
            // $('#title2_error').text('')
            // $('#body2_error').text('')
            $('#name_answer2_error').text('')   
    
            $("#editing").css("display", "none");
            $("#editing2").css("display", "block");
            var formData = new FormData($('#edit_answer_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('update_answer')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        $("#editing").css("display", "block");
                        $("#editing2").css("display", "none");
    
                        $('.close').click();
    
                        $('#position-top-start_edit').click();
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
    
                    }, error: function (reject) {
                            $("#editing").css("display", "block");
                            $("#editing2").css("display", "none");
                            var response = $.parseJSON(reject.responseText);
                            $.each(response.errors, function (key, val) {
                                $("#" + key + "2_error").text(val[0]);
                            });
                    }
                });
        }
    
        </script>

            {{-- fill delete modal answer --}}
    <script>
        $('#delete_answer').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id3').val(id);
        })
    </script>


    {{-- delete user --}}
    <script>
        function do_delete() {
            $("#delete_answer_button").css("display", "none");
            $("#delete_answer2").css("display", "block");
            var formData = new FormData($('#delete_answer_form')[0]);
                $.ajax({
                    type: 'post',
                    url: "{{ route('delete_answer') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                        $("#delete_answer2").css("display", "none");
                        $("#delete_answer_button").css("display", "block");
                        $('.close').click();
                        $('#position-top-start_delete').click();



                    },
                    error: function(reject) {}
                });
        }
    </script>





<script>
    $(document).ready(function() {
  // When the "status_correct" radio button is checked,
  // check all other radio buttons as "status_incorrect".
  $("#status_correct").click(function() {
    $("input[name='status']").not(this).prop("checked", false);
  });

  // When the "status_incorrect" radio button is checked,
  // uncheck all other radio buttons.
  $("#status_incorrect").click(function() {
    $("input[name='status']").prop("checked", false);
  });
});
</script>




    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="//cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script src="{{ asset('/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('/app-assets/js/scripts/extensions/ext-component-sweet-alerts.js') }}"></script>


    
    <script src="{{ asset('/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('/app-assets/js/scripts/forms/form-repeater.js') }}"></script>


@endsection
