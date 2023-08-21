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
        $lesson = DB::table('lessons')->where('id', request()->route('id'))->first();
    @endphp
    <h1> إختبارات الدرس {{ $lesson->name }}</h1>
@else
    <h1>قائمة الإختبارات</h1>
@endif


<br>

@if (!request()->route('user_id'))

@can('اضافة الاختبارات')
    

<a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">إضافة إختبار</a>
@endcan

@endif


@if (request()->route('user_id'))
@php
    $user = DB::table('users')->where('id', request()->route('user_id'))->first();
@endphp
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">اختبارات الطالب {{ $user->name }}</h4>
            </div>
            <div class="table-responsive">
                <table class="table yajra-datatable" id="yajra-datatable1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>إسم الإختبار</th>
                            <th>تابع للدرس</th>
                            <th>نوع الإختبار</th>
                            <th>المدة</th>
                            <th>عدد الأسئلة</th>
                            <th>المحاولات المتبقية</th>
                            <th>من أصل (محاولة)</th>
                            <th>الخصم لكل محاولة</th>
                            <th>درجة الطالب</th>
                            <th>من أصل (درجة)</th>
                            <th> العمليات </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@else

<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">الإختبارات</h4>
            </div>
            <div class="table-responsive">
                <table class="table yajra-datatable" id="yajra-datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>إسم الإختبار</th>
                            <th>تابع للدرس</th>
                            <th>نوع الإختبار</th>
                            <th>نوع المدخلات</th>
                            <th>عدد الدرجات </th>
                            <th>المدة</th>
                            <th>عدد الأسئلة</th>
                            <th>عدد المحاولات </th>
                            <th>الخصم لكل محاولة</th>
                            <th>ملاحظات</th>
                            <th>الممتحنين</th>
                            <th> العمليات </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endif


@if (request()->route('user_id'))

    {{-- modal add --}}
    <div class="form-modal-ex" id="modal_add">
        <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="padding: 2%;">
                        
                       
                        <h3 style="position: relative; right: 43%; top: 5%" id="myModalLabel33">إضافة إختبار</h3>
                      
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="add_quiz_form">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size: 20px;">إسم الإختبار</label>
                                    <div class="form-group">
                                        <input type="name" name="name" id="name" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label style="font-size: 20px;">اختر الدرس</label>
                                    <div class="form-group">
                                        <select name="lesson_id" id="lesson_id" class="form-control">
                                            <option value="">اختر درس</option>
                                            @foreach($lessons as $lesson)
                                            <option value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                                            @endforeach
                                        </select>
                                        <span id="lesson_id_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label style="font-size: 20px;">النوع</label>
                                    <div class="form-group">
                                        <input type="text" name="type" id="type" class="form-control" value="اختر الإجابة الصحيحة" />
                                        <span id="type_error" class="text-danger"></span>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label style="font-size: 20px;">اختر نوع المدخلات</label>
                                    <div class="form-group">
                                        <select name="input_type" id="input_type" class="form-control">
                                            <option value="">اختر نوع المدخلات</option>
                                            <option value="نص">نص</option>
                                            <option value="صور">صور</option>
                                        </select>
                                        <span id="input_type_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label style="font-size: 20px;">عدد الدرجات</label>
                                    <div class="form-group">
                                        <input type="numeric" name="points" id="points" class="form-control" />
                                        <span id="points_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label style="font-size: 20px;">المدة ( بالدقيقة )</label>
                                    <div class="form-group">
                                        <input type="numeric" name="time" id="time" class="form-control" />
                                        <span id="time_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label style="font-size: 20px;">عدد الأسئلة</label>
                                    <div class="form-group">
                                        <input type="numeric" name="questions_number" id="questions_number" class="form-control" />
                                        <span id="questions_number_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label style="font-size: 20px;">عدد المحاولات</label>
                                    <div class="form-group">
                                        <input type="numeric" name="attempts" id="attempts" class="form-control" />
                                        <span id="attempts_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label style="font-size: 20px;">الخصم لكل محاولة</label>
                                    <div class="form-group">
                                        <input type="numeric" name="deduction_per_attempt" id="deduction_per_attempt" class="form-control" />
                                        <span id="deduction_per_attempt_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size: 20px;">ملاحظات</label>
                                    <div class="form-group">
                                        <textarea type="text" name="notes" id="notes" class="form-control"></textarea>
                                        <span id="notes_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="display: none" id="add_quiz2" class="btn btn-primary btn-block">جاري الإضافة ...</button>
                            <button type="button" id="add_quiz" class="btn btn-primary btn-block">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @endif

{{-- edit quiz --}}
<div class="form-modal-ex" id="modal_add">
    <div class="modal fade text-left" id="edit_quiz" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 2%;">
                    <h4 class="modal-title" id="myModalLabel33">تعديل المرحلة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_quiz_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" id="id2">
                                <label style="font-size: 20px;">إسم الإختبار</label>
                                <div class="form-group">
                                    <input type="name" name="name" id="name2" class="form-control" />
                                    <span id="name2_error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label style="font-size: 20px;">اختر الدرس</label>
                                <div class="form-group">
                                    <select name="lesson_id" id="lesson_id2" class="form-control">
                                        <option value="">اختر درس</option>
                                        @foreach($lessons as $lesson)
                                        <option value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                                        @endforeach
                                    </select>
                                    <span id="lesson_id2_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label style="font-size: 20px;">النوع</label>
                                <div class="form-group">
                                    <input type="type" name="type" id="type2" class="form-control" />
                                    <span id="type2_error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label style="font-size: 20px;">اختر نوع المدخلات</label>
                                <div class="form-group">
                                    <select name="input_type" id="input_type2" class="form-control">
                                        <option value="">اختر نوع المدخلات</option>
                                        <option value="نص">نص</option>
                                        <option value="صور">صور</option>
                                    </select>
                                    <span id="input_type2_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label style="font-size: 20px;">عدد الدرجات</label>
                                <div class="form-group">
                                    <input type="numeric" name="points" id="points2" class="form-control" />
                                    <span id="points2_error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label style="font-size: 20px;">المدة</label>
                                <div class="form-group">
                                    <input type="numeric" name="time" id="time2" class="form-control" />
                                    <span id="time2_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label style="font-size: 20px;">عدد الأسئلة</label>
                                <div class="form-group">
                                    <input type="numeric" name="questions_number" id="questions_number2" class="form-control" />
                                    <span id="questions_number2_error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label style="font-size: 20px;">عدد المحاولات</label>
                                <div class="form-group">
                                    <input type="numeric" name="attempts" id="attempts2" class="form-control" />
                                    <span id="attempts2_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label style="font-size: 20px;">الخصم لكل محاولة</label>
                                <div class="form-group">
                                    <input type="numeric" name="deduction_per_attempt" id="deduction_per_attempt2" class="form-control" />
                                    <span id="deduction_per_attempt2_error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label style="font-size: 20px;">ملاحظات</label>
                                <div class="form-group">
                                    <textarea type="text" name="notes" id="notes2" class="form-control"></textarea>
                                    <span id="notes2_error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="add_quiz2" class="btn btn-primary btn-block">جاري التعديل...</button>
                        <button type="button" onclick="do_update()" id="add_quiz" class="btn btn-primary btn-block">تعديل</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    {{-- delete quiz --}}
    <div class="modal fade modal-danger text-left" id="delete_quiz" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel120">حذف الدرس</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="delete_quiz_form">
                        @csrf
                        <input type="hidden" name="id" id="id3">
                        هل انت متأكد من عملية الحذف ؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="delete_quiz2" style="display: none"
                        data-dismiss="modal">...يتم الحذف</button>
                    <button type="button" class="btn btn-danger" onclick="do_delete()" id="delete_quiz_button"
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
@if (request()->route('user_id'))


<script type="text/javascript">
    $(function() {
        var table = $('#yajra-datatable1').DataTable({
            processing: true,
            serverSide: true,
                 ajax: "{{ route('student_quizzes_data',$user_id) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },

                {data: 'name', name: 'name'},
                {data: 'lesson_id', name: 'lesson_id'},
                {data: 'type', name: 'type'},
                {data: 'time' , name: 'time'},
                {data: 'questions_number' , name: 'questions_number'},
                {data: 'remaining_attempts'},
                {data: 'attempts' , name: 'attempts'},
                {data: 'deduction_per_attempt' , name: 'deduction_per_attempt'},
                {data: 'student_points' , name: 'student_points'},
                {data: 'points' , name: 'points'},
                {data: 'action'},
            ],

            "lengthMenu": [
                [5, 25, 50, -1], [5, 25, 50, 'All'] 
            ], // page length options
        });
    });
</script>

@else


<script type="text/javascript">
    $(function() {
        var table = $('#yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            @if(isset($id))
                 ajax: "{{ route('get_quizzes_data',$id) }}",
            @else
            
                 ajax: "{{ route('get_quizzes_data') }}",
            @endif
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },

                {data: 'name', name: 'name'},
                {data: 'lesson_id', name: 'lesson_id'},
                {data: 'type', name: 'type'},
                {data: 'input_type', name: 'input_type'},
                {data: 'points' , name: 'points'},
                {data: 'time' , name: 'time'},
                {data: 'questions_number' , name: 'questions_number'},
                {data: 'attempts' , name: 'attempts'},
                {data: 'deduction_per_attempt' , name: 'deduction_per_attempt'},
                {data: 'notes' , name: 'notes'},
                {data: 'degrees' },
                {data: 'action'},
            ],

            "lengthMenu": [
                [5, 25, 50, -1], [5, 25, 50, 'All'] 
            ], // page length options
        });
    });
</script>

@endif

<script>
    $(document).on('click', '#add_quiz', function(e) {
        $('#name_error').text('');
        $('#section_id_error').text('');


        $("#add_quiz2").css("display", "block");
        $("#add_quiz").css("display", "none");
        var formData = new FormData($('#add_quiz_form')[0]);
        $.ajax({
            type: 'post',
            enctype: 'multipart/form-data',
            url: "{{ route('store_quiz') }}",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                $('.yajra-datatable').DataTable().ajax.reload(null, false);
                // $('.yajra-datatable1').DataTable().ajax.reload(null, false);
                $("#add_quiz2").css("display", "none");
                $("#add_quiz").css("display", "block");
                $('.close').click();
                $('#position-top-start').click(); 
                $('#name').val('');
                $('#lesson_id').val('');
                $('#type').val('');
                $('#input_type').val('');
                $('#points').val('');
                $('#time').val('');
                $('#questions_number').val('');
                $('#attempts').val('');
                $('#deduction_per_attempt').val('');
                $('#notes').val('');

            },

            error: function(reject) {
                $("#add_quiz2").css("display", "none");
                $("#add_quiz").css("display", "block");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });
    });
</script>


{{-- show edit quiz --}}
<script>
    $('#edit_quiz').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id                    = button.data('id');
        var name                  = button.data('name');
        var lesson_id             = button.data('lesson_id');
        var type                  = button.data('type');
        var input_type            = button.data('input_type');
        var points                = button.data('points');
        var time                  = button.data('time');
        var questions_number      = button.data('questions_number');
        var attempts              = button.data('attempts');
        var deduction_per_attempt = button.data('deduction_per_attempt');
        var notes                 = button.data('notes');
        
        var modal = $(this);
        modal.find('.modal-body #id2').val(id);
        modal.find('.modal-body #name2').val(name);
        modal.find('.modal-body #lesson_id2').val(lesson_id);
        modal.find('.modal-body #type2').val(type);
        modal.find('.modal-body #input_type2').val(input_type);
        modal.find('.modal-body #points2').val(points);
        modal.find('.modal-body #time2').val(time);
        modal.find('.modal-body #questions_number2').val(questions_number);
        modal.find('.modal-body #attempts2').val(attempts);
        modal.find('.modal-body #deduction_per_attempt2').val(deduction_per_attempt);
        modal.find('.modal-body #notes2').val(notes);

    })

</script> 

    {{-- update quiz --}}
    <script>
        function do_update(){
    
            // $('#title2_error').text('')
            // $('#body2_error').text('')
            $('#name2_error').text('')
    
            $("#editing").css("display", "none");
            $("#editing2").css("display", "block");
            var formData = new FormData($('#edit_quiz_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('update_quiz')}}",
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

            {{-- fill delete modal quiz --}}
    <script>
        $('#delete_quiz').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id3').val(id);
        })
    </script>


    {{-- delete quiz --}}
    <script>
        function do_delete() {
            $("#delete_quiz_button").css("display", "none");
            $("#delete_quiz2").css("display", "block");
            var formData = new FormData($('#delete_quiz_form')[0]);
                $.ajax({
                    type: 'post',
                    url: "{{ route('delete_quiz') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                        $("#delete_quiz2").css("display", "none");
                        $("#delete_quiz_button").css("display", "block");
                        $('.close').click();
                        $('#position-top-start_delete').click();



                    },
                    error: function(reject) {}
                });
        }
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


@endsection
