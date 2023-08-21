@extends('layouts.master')
@section('css')


<link rel="stylesheet" type="text/css"
href="{{ asset('/app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css"
href="{{ asset('/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
<link rel="stylesheet" type="text/css"
href="{{ asset('/app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css') }}">

<link href="{{  asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{  asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{  asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{  asset('app-assets/vendors/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{  asset('app-assets/vendors/css/responsive.dataTables.min.css') }}" rel="stylesheet">
{{-- <link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet"/> --}}
<!--Internal   Notify -->
<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />


@endsection

@section('title')
    المساعدين 
@stop

<!-- Internal Data table css -->


        






@section('content')

<h1>قائمة المساعدين</h1>
<br>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- row opened -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="col-sm-1 col-md-2">

                    @can('اضافة المساعدين')
                        
                  
                    <a class="btn btn-primary btn-sm" href="{{ route('create_user') }}">إضافة مساعد</a>
                    @endcan
                </div>
            </div>

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


            <div class="card-body">
                <div class="datatables-basic table dataTable no-footer dtr-column">
                    <table class="table table-hover" id="example" >
                        <thead>
                            <tr>
                                <th class="wd-10p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">اسم المساعد</th>
                                <th class="wd-20p border-bottom-0">البريد الالكتروني</th>
                                <th class="wd-15p border-bottom-0">حالة المساعد</th>
                                <th class="wd-15p border-bottom-0">نوع المساعد</th>
                                <th class="wd-10p border-bottom-0">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $admin)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>

                                        @if ($admin->status == 'مفعل')
                                        <div class="centered-container">
                                            <span class="label text-success d-flex" >
                                                <div class="dot-label bg-success ml-1"></div><i class="fas fa-circle fa-sm fa-beat-fade" style="margin-top: 6px; font-size: 9px;"></i> &nbsp; {{ $admin->status }} 
                                            </span>
                                        </div>
                                        @else
                                        <div class="centered-container">
                                            <span class="label text-danger d-flex" >
                                                <div class="dot-label bg-danger ml-1"></div><i class="fas fa-circle fa-sm fa-beat-fade" style="margin-top: 6px; font-size: 9px"></i> &nbsp; {{ $admin->status }}
                                            </span>
                                        </div>
                                        @endif
                                    </td>

                                    <td>
                                        @if (!empty($admin->getRoleNames()))
                                            @foreach ($admin->getRoleNames() as $v)
                                                <label class="badge badge-success">{{ $v }}</label>
                                            @endforeach
                                        @endif
                                    </td>

                                    <td>

                                        @can('تعديل المساعدين')
                                        <a href="{{ route('edit_user', $admin->id) }}" class="btn btn-sm btn-primary"> <i class="fas fa-edit"></i> تعديل</a>
                                        @endcan

                                        
                                        @can('حذف المساعدين')
                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                        data-user_id="{{ $admin->id }}" data-username="{{ $admin->name }}"
                                        data-id="{{ $admin->id }}" data-toggle="modal" href="#modaldemo9" title="حذف">حذف<i class="las la-trash"></i></a>
                                        @endcan
                                    
                                    

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    <!--/div-->

    <!-- Modal effects -->
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف المستخدم</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('user_delete', 'test') }}" method="POST">
                    
                    @csrf
                    <div class="modal-body">
                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                        <input type="hidden" name="user_id" id="user_id" value="">
                        <input class="form-control" name="username" id="username" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
            </div>
            </form>
        </div>
    </div>




<!-- /row -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('scripts')

{{-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script> --}}
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

<!--Internal  Datatable js -->
<script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
<!--Internal  Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
<!-- Internal Modal js-->
<script src="{{ URL::asset('assets/js/modal.js') }}"></script>



<script>
    new DataTable('#example');
</script>


<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var user_id = button.data('user_id')
        var username = button.data('username')
        var modal = $(this)
        modal.find('.modal-body #user_id').val(user_id);
        modal.find('.modal-body #username').val(username);
    })
</script>


@endsection
