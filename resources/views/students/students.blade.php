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

<style>
    .result-box {
        background-color: #f5f5f5;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .passed {
        color: #155724;
    }

    .failed {
        color: #721c24;
    }

    .result-label {
        font-weight: bold;
    }

    .badge {
        margin-bottom: 5px;
    }
</style>




@endsection

@section('title')
    لوحة التحكم
@endsection

@section('content')
    <button class="btn btn-outline-primary" style="display: none" onclick="msg_add()" id="position-top-start"></button>
    <button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()"
        id="position-top-start_edit"></button>
    <button class="btn btn-outline-primary" style="display: none"
        onclick="msg_delete()"id="position-top-start_delete"></button>

<br>
<br>
@if (Route::current()->parameter('id'))
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <?php $quiz = \App\Models\Quiz::where('id', $id)->first(); ?>
                    <h4 class="card-title"> الطلاب الممتحنين ل{{$quiz->name}}</h4>

                    @php
                    $totalDegree = \App\Models\Quiz::where('id', $id)->value('points');
                    $passedCount = \App\Models\MyQuiz::where('quiz_id', $id)->where('user_points', '>=', ($totalDegree / 2))->count();
                    $failedCount = \App\Models\MyQuiz::where('quiz_id', $id)->where('user_points', '<', ($totalDegree / 2))->count();
                @endphp
                
                <div class="result-box">
                    <div class="passed d-inline-block" style="margin-left: -30px;">
                        <span class="result-label">عدد الناجحين:</span>
                        <span class="badge badge-success">{{ $passedCount }}</span>
                    </div>
                    <div class="failed d-inline-block ml-3">
                        <span class="result-label">عدد الراسبين:</span>
                        <span class="badge badge-danger">{{ $failedCount }}</span>
                    </div>
                </div>
                
                    
                </div>
                <div class="table-responsive">
                    <table class="table yajra-datatable" id="yajra-datatable1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الإسم</th>
                                <th>البريد الالكتروني</th>
                                <th>رقم الهاتف</th>
                                <th>المرحلة</th>
                                {{-- <th>الدورات</th> --}}
                                <th>نوع الدراسة</th>
                                <th>درجة الإختبار</th>
                                <th>من أصل</th>
                                <th>عمليات</th>
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
                    <h4 class="card-title">قائمة الطلاب</h4>
                </div>
                <div class="table-responsive">
                    <table class="table yajra-datatable" id="yajra-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الإسم</th>
                                <th>البريد الالكتروني</th>
                                <th>رقم الهاتف</th>
                                <th>هاتف ولي الأمر</th>
                                <th>المرحلة</th>
                                <th>الدورات</th>
                                <th>نوع الدراسة</th>
                                <th>حالة التفعيل</th>
                                <th>إختباراته</th>
                                <th>عمليات</th>
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
                        <h4 class="modal-title" id="myModalLabel33"> إضافة مادة</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="add_student_form">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size:20px">إسم المادة </label>
                                    <div class="form-group">
                                        <input type="name" name="name" id="name" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="display: none" id="add_student2"
                                class="btn btn-primary btn-block">جاري الإضافة ...</button>
                            <button type="button" id="add_student" class="btn btn-primary btn-block">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- edit student --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="edit_student" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">تعديل المادة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_student_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" id="id2">
                                <label>إسم المادة</label>
                                <div class="form-group">
                                    <input type="text" placeholder="name" name="student_name" id="name_student2" class="form-control" />
                                    <span id="name_student2_error" class="text-danger"></span>
                                </div>
                            </div>


                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="editing2" class="btn btn-primary btn-block">editing...</button>
                        <button type="button" id="editing" onclick="do_update()" class="btn btn-primary btn-block">edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    {{-- delete student --}}
    <div class="modal fade modal-danger text-left" id="delete_student" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel120">حذف المادة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="delete_student_form">
                        @csrf
                        <input type="hidden" name="id" id="id3">
                        هل انت متأكد من عملية الحذف ؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="delete_student2" style="display: none"
                        data-dismiss="modal">...يتم الحذف</button>
                    <button type="button" class="btn btn-danger" onclick="do_delete()" id="delete_student_button"
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
                title: 'تمت الإضافة بنجاح',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                    confirmButton: 'btn btn-danger'
                },
                buttonsStyling: false

            });

        }
    </script>

    
<script>
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





    <script>
        function msg_delete() {

            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تم الحذف بنجاح',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                    confirmButton: 'btn btn-danger'
                },
                buttonsStyling: false

            });

        }
    </script>


@if (Route::current()->parameter('id'))

    <script type="text/javascript">
        
        $(function () {
        var table = $('#yajra-datatable1').DataTable({
            language: {
        url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/ar.json',
    },
            processing: true,
            serverSide: true,
            ajax: "{{ route('get_student_data', ['id' => $id]) }}",

            columns: [
                {data: 'DT_RowIndex',           name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name'                  ,name: 'name'},
                {data: 'email'                  ,name: 'email'},
                {data: 'phone'                  ,name: 'phone'},
                {data: 'level'                  ,name: 'level'},
                // {data: 'courses'},
                {data: 'study_type'                  ,name: 'study_type'},  
                {data: 'degree'},
                {data: 'total_degree'},           
                {data: 'action'},

            ],
            "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
        });
        });
    </script>

@else


<script type="text/javascript">
        
    $(function () {
    var table = $('#yajra-datatable').DataTable({
        language: {
        url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/ar.json',
    },
        processing: true,
        serverSide: true,
        ajax: "{{ route('get_students_data') }}",
        columns: [
            {data: 'DT_RowIndex',           name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name'                  ,name: 'name'},
            {data: 'email'                  ,name: 'email'},
            {data: 'phone'                  ,name: 'phone'},
            {data: 'parent_phone'                  ,name: 'parent_phone'},
            {data: 'level'                  ,name: 'level'},
            {data: 'courses'},
            {data: 'study_type'                  ,name: 'study_type'},             
            {data: 'verify_status'                  ,name: 'verify_status'},
            {data: 'his_quizzes'},
            
            {data: 'action'},

        ],
        "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
    });
    });
</script>

@endif


    {{-- <script>
        $(document).on('click', '#add_student', function(e) {
            $('#name_error').text('');


            $("#add_student2").css("display", "block");
            $("#add_student").css("display", "none");
            var formData = new FormData($('#add_student_form')[0]);
            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{ route('store_student') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    $("#add_student2").css("display", "none");
                    $("#add_student").css("display", "block");
                    $('.close').click();
                    // toastr.success('student added successfully.');
                    $('#position-top-start').click(); // Trigger the button click
                    $('#name').val('');
                },

                error: function(reject) {
                    $("#add_student2").css("display", "none");
                    $("#add_student").css("display", "block");
                    var response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function(key, val) {
                        $("#" + key + "_error").text(val[0]);
                    });
                }
            });
        });
    </script> --}}

    {{-- show edit student --}}
    <script>
    $('#edit_student').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget)
        var id =                  button.data('id')
        var name =                button.data('name')

        var modal = $(this)
        modal.find('.modal-body #id2').val(id);
        modal.find('.modal-body #name_student2').val(name);
    })
    </script>  


    {{-- update student --}}
<script>
    function do_update(){

        // $('#title2_error').text('')
        // $('#body2_error').text('')
        $('#name_student2_error').text('')

        $("#editing").css("display", "none");
        $("#editing2").css("display", "block");
        var formData = new FormData($('#edit_student_form')[0]);
            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{route('update_student')}}",
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




    {{-- fill delete modal user --}}
    <script>
        $('#delete_student').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id3').val(id);
        })
    </script>


    {{-- delete user --}}
    <script>
        function do_delete() {
            $("#delete_student_button").css("display", "none");
            $("#delete_student2").css("display", "block");
            var formData = new FormData($('#delete_student_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{ route('delete_student') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    $("#delete_student2").css("display", "none");
                    $("#delete_student_button").css("display", "block");
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
