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
            .table td {
                text-align: center;
                vertical-align: middle;
            }
        </style>
        <style>
            .table th {
                text-align: center;
                vertical-align: middle;
            }
        </style>

        <style>.centered-container {
            display: flex;
            justify-content: center;
          }
          </style>


@endsection



@section('title')
    لوحة التحكم
@endsection



@section('content')

<button class="btn btn-outline-primary" style="display: none" onclick="msg_add()" id="position-top-start"></button>
<button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()" id="position-top-start_edit"></button>



@if (Route::current()->parameter('id'))

    @php

        $id = Route::current()->parameter('id');
        $level = DB::table('levels')->where('id', $id)->first();
    
    @endphp

    <h1>دورات مرحلة {{ $level->name }}</h1>
    {{-- <p>إسم المادة: {{ $subject->name }}</p> --}}
    <br>

    <a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">إضافة دورة</a>

    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">الدورات</h4>
                </div>
                <div class="table-responsive">
                    <table class="table yajra-datatable" id="yajra-datatable1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>إسم الدورة</th>
                                <th>عدد الأقسام</th>
                                <th>صورة العرض</th>
                                <th>الوصف</th>
                                <th>نوع الكورس</th>
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

    @elseif(Route::current()->parameter('user_id'))

    @php

    $user = DB::table('users')->where('id', $user_id)->first();
    @endphp

    <h1>دورات {{ $user->name }}</h1>
    {{-- <p>إسم المادة: {{ $subject->name }}</p> --}}
    <br>
    
    <a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">إضافة دورة</a>

    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">الدورات</h4>
                </div>
                <div class="table-responsive">
                    <table class="table yajra-datatable" id="yajra-datatable3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>إسم الدورة</th>
                                <th>عدد الأقسام</th>
                                <th>صورة العرض</th>
                                <th>الوصف</th>
                                <th>نوع الكورس</th>
                                <th>درجته في الدورة</th>
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

@else
<h1>قائمة الدورات</h1>

<br>

@can('اضافة الدورات')

<a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%" onmouseover="startAnimation(this)" onmouseout="stopAnimation(this)">
    <i id="plus-icon" class="fas fa-plus-square" style="color: #ffffff;"></i>&nbsp; إضافة دورة
</a>

@endcan

<script>
    function startAnimation(element) {
        $(element).find('#plus-icon').addClass('beat-animation');
    }

    function stopAnimation(element) {
        $(element).find('#plus-icon').removeClass('beat-animation');
    }
</script>

<style>
    @keyframes beat {
        0% { transform: scale(1); }
        50% { transform: scale(1.4); }
        100% { transform: scale(1); }
    }

    .beat-animation {
        animation: beat 1.5s infinite;
    }
</style>




<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">المراحل</h4>
            </div>
            <div class="table-responsive">
                <table class="table yajra-datatable" id="yajra-datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>إسم الدورة</th>
                            <th>عدد الأقسام</th>
                            <th>صورة العرض</th>
                            <th>الوصف</th>
                            <th>نوع الكورس</th>
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

@endif


    {{-- modal add --}}
    <div class="form-modal-ex" id="modal_add">
        <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33"> إضافة مرحلة</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="add_course_form">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size:20px">إسم الدورة </label>
                                    <div class="form-group">
                                        <input type="name" name="name" id="name" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>

                                    <label style="font-size:20px">اسم المرحلة </label>
                                    <div class="form-group">
                                        <select name="level_id" id="level_id" class="form-control">
                                            <option value="">اختر المرحلة</option>
                                            @foreach($levels as $level)
                                                <option value="{{ $level->id }}">{{ $level->name }} ({{ $level->subject->name }})</option>
                                            @endforeach
                                        </select>

                                        <label style="font-size:20px">الوصف</label>
                                        <div class="form-group">
                                            <input type="name" name="name" id="name" class="form-control" />
                                            <span id="name_error" class="text-danger"></span>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label style="font-size: 20px">ارفاق صورة</label>
                                                <div class="form-group">
                                                    <input type="file" name="image" id="image" class="form-control" />
                                                    <span id="image_error" class="text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label style="font-size: 20px">نوع الدورة</label>
                                                <div class="form-group">
                                                    <select name="is_free" id="is_free" class="form-control">
                                                        <option value="" disabled selected>حدد نوع الدورة</option>
                                                        <option value="0">مدفوع</option>
                                                        <option value="1">مجاني</option>
                                                    </select>
                                                    <span id="subject_id_error" class="text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="display: none" id="add_course2"
                                class="btn btn-primary btn-block">جاري الإضافة ...</button>
                            <button type="button" id="add_course" class="btn btn-primary btn-block">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


{{-- edit course --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="edit_course" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">تعديل الدورة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_course_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" id="id2">
                                <label style="font-size:18px">إسم الدورة</label>
                                <div class="form-group">
                                    <input type="text" placeholder="name" name="name" id="name_course2"
                                        class="form-control" />
                                    <span id="name_course2_error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label style="font-size:18px">اختر المرحلة</label>
                                <div class="form-group">
                                    <select name="level_id" id="level_id" class="form-control">
                                        {{-- <option value="">اختر المادة</option> --}}
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->id }}">{{ $level->name }}
                                                ({{ $level->subject->name }})</option>
                                        @endforeach
                                    </select>
                                    <span id="level_id_error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <label style="font-size:20px">الوصف</label>
                        <div class="form-group">
                            <input type="text" name="description" id="description" class="form-control" />
                            <span id="description_error" class="text-danger"></span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label style="font-size: 20px">ارفاق صورة</label>
                                <div class="form-group">
                                    <input type="file" name="image" id="image" class="form-control" onchange="previewImage(event)" />
                                    <span id="image_error" class="text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <img id="image_preview" style="width: 50%" src="" alt="Image Preview" style="max-width: 100%; max-height: 200px;">
                                </div>
                            </div>
                    
                            
                            <div class="col-md-6">
                                <label style="font-size: 20px">نوع الدورة</label>
                                <div class="form-group">
                                    <select name="is_free" id="is_free" class="form-control">
                                        <option value="" disabled selected>حدد نوع الدورة</option>
                                        <option value="0">مدفوع</option>
                                        <option value="1">مجاني</option>
                                    </select>
                                    <span id="subject_id_error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="editing2" class="btn btn-primary btn-block">جاري التعديل ...</button>
                        <button type="button" id="editing" onclick="do_update()" class="btn btn-primary btn-block">تعديل</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>





    {{-- delete course --}}
    <div class="modal fade modal-danger text-left" id="delete_course" tabindex="-1" role="dialog"
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
                    <form id="delete_course_form">
                        @csrf
                        <input type="hidden" name="id" id="id3">
                        هل انت متأكد من عملية الحذف ؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="delete_course2" style="display: none"
                        data-dismiss="modal">...يتم الحذف</button>
                    <button type="button" class="btn btn-danger" onclick="do_delete()" id="delete_course_button"
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
            title: 'تم إضافة الدورة بنجاح',
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

</script>
@if (Route::current()->parameter('user_id'))

<script type="text/javascript">
    $(function() {
        var table = $('#yajra-datatable3').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('student_courses_data', ['user_id' => $user_id]) }}",

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {data: 'name', name: 'name'},
                {data: 'sections_count'},
                {data: 'image', name: 'image'},
                {data: 'description', name: 'description'},
                {data: 'is_free', name: 'is_free'},
                {data: 'degree'},
                {data: 'action'},
            ],

            "lengthMenu": [
                [5, 25, 50, -1], [5, 25, 50, 'All'] 
            ], // page length options
        });
    });
</script>

@endif



<script type="text/javascript">
    $(function() {
        var table = $('#yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('get_courses_data') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {data: 'name', name: 'name'},
                {data: 'sections_count'},
                {data: 'image', name: 'image'},
                {data: 'description', name: 'description'},
                {data: 'is_free', name: 'is_free'},
                {data: 'action'},
            ],

            "lengthMenu": [
                [5, 25, 50, -1], [5, 25, 50, 'All'] 
            ], // page length options
        });
    });
</script>


@if (Route::current()->parameter('id'))

<script type="text/javascript">
$(function() {
    var table = $('#yajra-datatable1').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('level_courses_data', ['id' => $id]) }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {data: 'name', name: 'name'},
            {data: 'sections_count'},
            {data: 'image', name: 'image'},
            {data: 'description', name: 'description'},
            {data: 'is_free', name: 'is_free'},
            {data: 'action', searchable: false},
        ],

        "lengthMenu": [
            [5, 25, 50, -1], [5, 25, 50, 'All'] 
        ], // page length options
    });
});
</script>

@endif


<script>
    $(document).on('click', '#add_course', function(e) {
        $('#name_error').text('');
        $('#level_id_error').text('');
        $('#image_error').text('');


        $("#add_course2").css("display", "block");
        $("#add_course").css("display", "none");
        var formData = new FormData($('#add_course_form')[0]);
        $.ajax({
            type: 'post',
            enctype: 'multipart/form-data',
            url: "{{ route('store_course') }}",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                $('.yajra-datatable').DataTable().ajax.reload(null, false);
                // $('.yajra-datatable1').DataTable().ajax.reload(null, false);
                $("#add_course2").css("display", "none");
                $("#add_course").css("display", "block");
                $('.close').click();
                $('#position-top-start').click(); 
                $('#name').val('');
                $('#level_id').val('');
                $('#description').val('');
                $('#image').val('');
                $('#is_free').val('');
            },

            error: function(reject) {
                $("#add_course2").css("display", "none");
                $("#add_course").css("display", "block");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });
    });
</script>


{{-- show edit level --}}
<script>
    $(document).ready(function() {
        $('#edit_course').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var course_id = button.data('level_id');
            var description = button.data('description');
            var image = button.data('image');
            var is_free = button.data('is_free');

            var modal = $(this);
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #name_course2').val(name);
            modal.find('.modal-body #level_id').val(course_id);
            modal.find('.modal-body #description').val(description);
            modal.find('.modal-body #image_preview').attr('src', image);
            modal.find('.modal-body #is_free').val(is_free);

            // Image click event handling
            modal.find('.modal-body #image_preview').click(function() {
                modal.find('.modal-body #image').click();
            });
        });
    });
</script>



    {{-- update course --}}
    <script>
        function do_update(){
    
            // $('#title2_error').text('')
            // $('#body2_error').text('')
            // $('#name_course2_error').text('')
    
            $("#editing").css("display", "none");
            $("#editing2").css("display", "block");
            var formData = new FormData($('#edit_course_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('update_course')}}",
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

            {{-- fill delete modal course --}}
    <script>
        $('#delete_course').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id3').val(id);
        })
    </script>


    {{-- delete user --}}
    <script>
        function do_delete() {
            $("#delete_course_button").css("display", "none");
            $("#delete_course2").css("display", "block");
            var formData = new FormData($('#delete_course_form')[0]);
                $.ajax({
                    type: 'post',
                    url: "{{ route('delete_course') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                        $("#delete_course2").css("display", "none");
                        $("#delete_course_button").css("display", "block");
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
