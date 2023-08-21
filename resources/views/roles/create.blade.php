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
        .title-highlight {
            background-image: linear-gradient(to right, #f8e2b7, #f3c07f);
            padding: 2px 8px;
            border-radius: 4px;
            display: inline-block;
        }
    </style>

@endsection

@section('title')
    اضافة الصلاحيات 
@endsection

@section('page-header')
    <!-- breadcrumb -->

    <!-- breadcrumb -->
@endsection

@section('content')


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


    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>خطا</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h5 class="content-title mb-0 my-auto">الصلاحيات</h5>
                <span class="text-muted mt-0 tx-15 mr-1 mb-0">/ اضافة نوع مساعد</span>
            </div>
        </div>
    </div>
    <br>

    {!! Form::open(['route' => 'store_role', 'method' => 'POST']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        <div class="col-xs-7 col-sm-7 col-md-7">
                            <div class="form-group">
                                <p><span class="title-highlight">اسم الدور :</span></p>
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <ul id="treeview1">
                        <li>
                            <a href="#">الصلاحيات</a>
                            <br><br>
                            <ul>
                                <div class="row justify-content-center">
                                    @foreach ($permission as $value)
                                        @if ($value->parent == 0)
                                            <div class="col-xs-12 col-sm-6 col-md-4 mb-4" style="border-style: ridge; padding: 1.5%; background-color: #f0efea; border-radius: 10px; margin-bottom: 20px; width: 80%; max-width: 400px; margin-right: 10px; margin-left: 10px;">
                                                <label style="font-size: 14px; font-size: 26px;">
                                                    {{ Form::checkbox('permission[]', $value->id, false, ['class' => 'name', 'data-parent' => $value->name, 'onclick' => 'checkall()']) }}
                                                    <span class="title-highlight">{{ $value->name }}</span>
                                                </label>
                                                <br> <br>

                                                <?php $permissions_chi = Spatie\Permission\Models\Permission::where('parent', $value->id)->get(); ?>
                                                <?php $permissions_chi_cont = Spatie\Permission\Models\Permission::where('parent', $value->id)->count(); ?>

                                                @if ($permissions_chi_cont > 5)
                                                    <div class="row">
                                                        @foreach ($permissions_chi as $key => $permissions_ch)
                                                            <div class="col-md-6">
                                                                <div style="margin-right: 8%;">
                                                                    <label style="font-size: 14px; color: black;">
                                                                        {{ Form::checkbox('permission[]', $permissions_ch->id, false, ['class' => 'name', 'data-children' => $value->name, 'id' => 'children', 'onclick' => "nothing(" . $key . ")"]) }}
                                                                        {{ $permissions_ch->name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    @foreach ($permissions_chi as $key => $permissions_ch)
                                                        <div style="margin-right: 8%;">
                                                            <label style="font-size: 14px; color: black;">
                                                                {{ Form::checkbox('permission[]', $permissions_ch->id, false, ['class' => 'name', 'data-children' => $value->name, 'onclick' => "nothing(" . $key . ")"]) }}
                                                                {{ $permissions_ch->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                @endif

                                                <br>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </ul>
                        </li>
                    </ul>

                    <div class="modal-footer">
                        <button type="submit" id="add_role" class="btn btn-primary btn-block">اضافة</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection










    
    
@section('scripts')
    <!-- Internal Treeview js -->
    <script src="{{ URL::asset('assets/plugins/treeview/treeview.js') }}"></script>

    

    <script>

            var parentCheckboxes = document.querySelectorAll('input[name="permission[]"][data-parent]');
            
            for (var i = 0; i < parentCheckboxes.length; i++) {
                parentCheckboxes[i].addEventListener('change', function() {
                    var parentCheckbox = this;
                    var parentName = parentCheckbox.getAttribute('data-parent');
                    var childPermissions = document.querySelectorAll('input[name="permission[]"][data-children="' + parentName + '"]');

                    for (var j = 0; j < childPermissions.length; j++) {
                        childPermissions[j].checked = parentCheckbox.checked;
                    }
                })
            }



    </script>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
@endsection
