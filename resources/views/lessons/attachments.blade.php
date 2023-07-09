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
    <button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()"
        id="position-top-start_edit"></button>
    <button class="btn btn-outline-primary" style="display: none"
        onclick="msg_delete()"id="position-top-start_delete"></button>


        @php
        $lesson = DB::table('lessons')->where('id', request()->route('id'))->first();
    @endphp
    <h1>  مرفقات   {{ $lesson->name }}</h1>

    <a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">إضافة مرفق</a>

    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">المرفقات</h4>
                </div>
                <div class="table-responsive">
                    <table class="table yajra-datatable" id="yajra-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم المرفق</th>
                                <th>رابط المرفق</th>
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

    {{-- modal add --}}
    <div class="form-modal-ex" id="modal_add">
        <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33"> إضافة مرفق</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="add_lesson_attachment_form">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size:20px">إسم المرفق </label>
                                    <div class="form-group">
                                        <input type="file_name" name="file_name" id="file_name" class="form-control" />
                                        <span id="file_name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>

                            <label style="font-size:20px">اسم الدرس </label>
                            <div class="form-group">
                                <select name="lesson_id" id="lesson_id" class="form-control">
                                    <option value="">اختر درس</option>
                                    @foreach($lessons as $lesson)
                                        <option value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                                    @endforeach
                                </select>
                                <span id="lesson_id_error" class="text-danger"></span>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size: 20px">إضافة الملف</label>
                                    <div class="form-group">
                                        <input type="file" name="file_link" id="file_link" class="form-control" onchange="previewImage(event)" />
                                        <span id="file_link_error" class="text-danger"></span>
                                    </div>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" style="display: none" id="add_lesson_attachment2"
                                class="btn btn-primary btn-block">جاري الإضافة ...</button>
                            <button type="button" id="add_lesson_attachment" class="btn btn-primary btn-block">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- edit lesson_attachment --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="edit_lesson_attachment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">تعديل المادة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_lesson_attachment_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" id="id2">
                                <label style="font-size: 20px">إسم المرفق</label>
                                <div class="form-group">
                                    <input type="text" placeholder="file_name" name="file_name" id="file_name2" class="form-control" />
                                    <span id="file_name2_error" class="text-danger"></span>
                                </div>
                            </div>
                     </div>

                        
                        <label style="font-size:20px">اسم الدرس </label>
                        <div class="form-group">
                            <select name="lesson_id" id="lesson_id2" class="form-control">
                                <option value="">اختر درس</option>
                                @foreach($lessons as $lesson)
                                    <option value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                                @endforeach
                            </select>
                            <span id="lesson_id2_error" class="text-danger"></span>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label style="font-size: 20px">إضافة الملف</label>
                                <div class="form-group">
                                    <input type="file" name="file_link" id="file_link2" class="form-control" onchange="previewImage(event)" />
                                    <span id="file_link_error" class="text-danger"></span>
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


    {{-- delete lesson_attachment --}}
    <div class="modal fade modal-danger text-left" id="delete_lesson_attachment" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel120">حذف المرفق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="delete_lesson_attachment_form">
                        @csrf
                        <input type="hidden" name="id" id="id3">
                        هل انت متأكد من عملية الحذف ؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="delete_lesson_attachment2" style="display: none"
                        data-dismiss="modal">...يتم الحذف</button>
                    <button type="button" class="btn btn-danger" onclick="do_delete()" id="delete_lesson_attachment_button"
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



    <script type="text/javascript">
        
        $(function () {
        var table = $('#yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('get_lesson_attachments_data' , ['id' => $id]) }}",
            columns: [
                {data: 'DT_RowIndex',           name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'file_name'       ,name: 'file_name'},
                {data: 'file_link'       ,name: 'file_link'},
                {data: 'action'},
            ],
            "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
        });
        });
    </script>



    <script>
        $(document).on('click', '#add_lesson_attachment', function(e) {
            $('#file_name_error').text('');


            $("#add_lesson_attachment2").css("display", "block");
            $("#add_lesson_attachment").css("display", "none");
            var formData = new FormData($('#add_lesson_attachment_form')[0]);
            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{ route('store_lesson_attachment') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    $("#add_lesson_attachment2").css("display", "none");
                    $("#add_lesson_attachment").css("display", "block");
                    $('.close').click();
                    // toastr.success('lesson_attachment added successfully.');
                    $('#position-top-start').click(); // Trigger the button click
                    $('#file_name').val('');
                    $('#file_link').val('');
                },

                error: function(reject) {
                    $("#add_lesson_attachment2").css("display", "none");
                    $("#add_lesson_attachment").css("display", "block");
                    var response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function(key, val) {
                        $("#" + key + "_error").text(val[0]);
                    });
                }
            });
        });
    </script>

    {{-- show edit lesson_attachment --}}
    <script>
    $('#edit_lesson_attachment').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget)
        var id =                  button.data('id')
        var file_name =                button.data('file_name')
        var file_link =                button.data('file_link')
        var lesson_id =                button.data('lesson_id')

        var modal = $(this)
        modal.find('.modal-body #id2').val(id);
        modal.find('.modal-body #file_name2').val(file_name);
        modal.find('.modal-body #file_link2').val(file_link);
        modal.find('.modal-body #lesson_id2').val(lesson_id);
    })
    </script>  


    {{-- update lesson_attachment --}}
<script>
    function do_update(){

        // $('#title2_error').text('')
        // $('#body2_error').text('')
        $('#file_name2_error').text('')

        $("#editing").css("display", "none");
        $("#editing2").css("display", "block");
        var formData = new FormData($('#edit_lesson_attachment_form')[0]);
            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{route('update_lesson_attachment')}}",
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
        $('#delete_lesson_attachment').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id3').val(id);
        })
    </script>


    {{-- delete user --}}
    <script>
        function do_delete() {
            $("#delete_lesson_attachment_button").css("display", "none");
            $("#delete_lesson_attachment2").css("display", "block");
            var formData = new FormData($('#delete_lesson_attachment_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{ route('delete_lesson_attachment') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    $("#delete_lesson_attachment2").css("display", "none");
                    $("#delete_lesson_attachment_button").css("display", "block");
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
