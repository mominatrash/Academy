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

@if (request()->route('id'))
    @php
        $subject = DB::table('subjects')->where('id', request()->route('id'))->first();
    @endphp
    <h1>مراحل مادة ال{{ $subject->name }}</h1>
@else
    <h1>قائمة المراحل</h1>
@endif


<br>

@can('اضافة المراحل')
    

<a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">إضافة مرحلة</a>

@endcan

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
                            <th>إسم المرحلة</th>
                            <th>عدد الدورات</th>
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
    <div class="form-modal-ex" id="modal_add">
        <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="padding: 2%;">
                        <h3 style="position: relative;right: 43%; top 5%" id="myModalLabel33"> إضافة مرحلة</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="add_level_form">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size:20px">إسم المرحلة </label>
                                    <div class="form-group">
                                        <input type="name" name="name" id="name" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>

                                    <label style="font-size:20px">اسم المادة </label>
                                    <div class="form-group">
                                        <select name="subject_id" id="subject_id" class="form-control">
                                            <option value="">اختر المادة</option>
                                            @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                            @endforeach
                                        </select>
                                        <span id="subject_id_error" class="text-danger"></span>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="display: none" id="add_level2"
                                class="btn btn-primary btn-block">جاري الإضافة ...</button>
                            <button type="button" id="add_level" class="btn btn-primary btn-block">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


{{-- edit level --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="edit_level" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">تعديل المرحلة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_level_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" id="id2">
                                <label style="font-size:18px">إسم المرحلة</label>
                                <div class="form-group">
                                    <input type="text" placeholder="name" name="level_name" id="name_level2" class="form-control" />
                                    <span id="name_level2_error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <label style="font-size:18px">اختر المادة </label>
                        <div class="form-group">
                            <select name="subject_id" id="subject_id" class="form-control">
                                {{-- <option value="">اختر المادة</option> --}}
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                            <span id="subject_id_error" class="text-danger"></span>
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


    {{-- delete level --}}
    <div class="modal fade modal-danger text-left" id="delete_level" tabindex="-1" role="dialog"
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
                    <form id="delete_level_form">
                        @csrf
                        <input type="hidden" name="id" id="id3">
                        هل انت متأكد من عملية الحذف ؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="delete_level2" style="display: none"
                        data-dismiss="modal">...يتم الحذف</button>
                    <button type="button" class="btn btn-danger" onclick="do_delete()" id="delete_level_button"
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

</script>

<script type="text/javascript">
    $(function() {
        var table = $('#yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            @if(isset($id))
                 ajax: "{{ route('get_levels_data',$id) }}",
            @else
            
                 ajax: "{{ route('get_levels_data') }}",
            @endif
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {data: 'name', name: 'name'},
                {data: 'courses_count'},
                {data: 'action'},
            ],

            "lengthMenu": [
                [5, 25, 50, -1], [5, 25, 50, 'All'] 
            ], // page length options
        });
    });
</script>



<script>
    $(document).on('click', '#add_level', function(e) {
        $('#name_error').text('');
        $('#subject_id_error').text('');


        $("#add_level2").css("display", "block");
        $("#add_level").css("display", "none");
        var formData = new FormData($('#add_level_form')[0]);
        $.ajax({
            type: 'post',
            enctype: 'multipart/form-data',
            url: "{{ route('store_level') }}",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                $('.yajra-datatable').DataTable().ajax.reload(null, false);
                // $('.yajra-datatable1').DataTable().ajax.reload(null, false);
                $("#add_level2").css("display", "none");
                $("#add_level").css("display", "block");
                $('.close').click();
                $('#position-top-start').click(); 
                $('#name').val('');
                $('#subject_id').val('');
            },

            error: function(reject) {
                $("#add_level2").css("display", "none");
                $("#add_level").css("display", "block");
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
    $('#edit_level').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var subject_id = button.data('subject_id');
        
        var modal = $(this);
        modal.find('.modal-body #id2').val(id);
        modal.find('.modal-body #name_level2').val(name);
        modal.find('.modal-body #subject_id').val(subject_id);
    })

</script> 

    {{-- update level --}}
    <script>
        function do_update(){
    
            // $('#title2_error').text('')
            // $('#body2_error').text('')
            $('#name_level2_error').text('')
    
            $("#editing").css("display", "none");
            $("#editing2").css("display", "block");
            var formData = new FormData($('#edit_level_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('update_level')}}",
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

            {{-- fill delete modal level --}}
    <script>
        $('#delete_level').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id3').val(id);
        })
    </script>


    {{-- delete user --}}
    <script>
        function do_delete() {
            $("#delete_level_button").css("display", "none");
            $("#delete_level2").css("display", "block");
            var formData = new FormData($('#delete_level_form')[0]);
                $.ajax({
                    type: 'post',
                    url: "{{ route('delete_level') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                        $("#delete_level2").css("display", "none");
                        $("#delete_level_button").css("display", "block");
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
