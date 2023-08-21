@extends('layouts.master')
@section('css')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@section('title')
    صلاحيات المستخدمين - مورا سوفت للادارة القانونية
@stop


@endsection
@section('page-header')
<!-- breadcrumb -->

<!-- breadcrumb -->
@endsection
@section('content')

<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h5 class="content-title mb-0 my-auto">المساعدين</h5><span class="text-muted mt-0 tx-15 mr-1 mb-0">/ صلاحيات
                المساعدين</span>
        </div>
    </div>
</div>

<br>


@if (session()->has('Add'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم اضافة الصلاحية بنجاح",
                type: "success"
            });
        }
    </script>
@endif

@if (session()->has('edit'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم تحديث بيانات الصلاحية بنجاح",
                type: "success"
            });
        }
    </script>
@endif

@if (session()->has('delete'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم حذف الصلاحية بنجاح",
                type: "error"
            });
        }
    </script>
@endif

<!-- row -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">
                            @can('اضافة الصلاحيات')
                                <a class="btn btn-primary btn-sm" href="{{ route('create_role') }}">اضافة</a>
                                <br>
                            @endcan
                        </div>
                    </div>
                    <br>
                    <br>
                </div>



            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mg-b-0 text-md-nowrap table-hover ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through roles to display "Admin" role at the top -->
                            @foreach ($roles as $key => $role)
                                @if ($role->name === 'Admin')
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @can('عرض الصلاحيات')
                                            <a class="btn btn-success btn-sm"
                                            href="{{ route('show_details', $role->id) }}">عرض</a>
                                            @endcan

                                            @can('تعديل الصلاحيات')
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('edit_role', $role->id) }}">تعديل</a>
                                                @endcan
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                            <!-- Loop through roles to display other roles below "Admin" -->
                            @foreach ($roles as $key => $role)
                                @if ($role->name !== 'Admin')
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @can('عرض الصلاحيات')
                                                <a class="btn btn-success btn-sm"
                                                    href="{{ route('show_details', $role->id) }}">عرض</a>
                                            @endcan

                                            @can('تعديل الصلاحيات')
                                                <a class="btn btn-primary btn-sm"
                                                    href="{{ route('edit_role', $role->id) }}">تعديل</a>
                                            @endcan

                                            @can('حذف الصلاحيات')
                                                @if ($role->name !== 'Admin')
                                                    <form method="POST"
                                                        action="{{ route('delete_role', ['id' => $role->id]) }}"
                                                        style="display:inline">
                                                        @csrf
                                                        <input type="hidden" name="role_id" value="{{ $role->id }}">
                                                        <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                                    </form>
                                                @endif
                                            @endcan
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection
