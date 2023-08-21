@extends('layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />
@section('title')
     تعديل صلاحيات المساعد
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الصلاحيات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل
                الصلاحيات</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection


@section('content')

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

<style>
    .title-highlight {
        background-image: linear-gradient(to right, #f8e2b7, #f3c07f);
        padding: 2px 8px;
        border-radius: 4px;
        display: inline-block;
    }
</style>

{!! Form::model($role, ['method' => 'POST', 'route' => ['roles_update', $role->id]]) !!}
<!-- row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    <div class="form-group">
                        <p>اسم الدور :</p>
                        {!! Form::hidden('role_id', $role->id) !!}
                        {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                    </div>
                </div>
                
                    <!-- col -->
                   
                        <ul id="treeview1">
                            <br>
                            <li>
                                <h4>الصلاحيات</h4>
                                <br>
                                <br>
                                <ul>
                                    <div class="row" style="display: flex; justify-content: center;">
                                        @foreach ($permission as $value)
                                            @if ($value->parent == 0)
                                                <div class="col-xs-12 col-sm-6 col-md-4 mb-4"
                                                     style="border-style: ridge; padding: 1.5%; background-color: #f0efea; border-radius: 10px; margin-bottom: 20px; width: 80%; max-width: 400px; margin-right: 10px; margin-left: 10px;">
                                                    <label style="font-size: 14px; font-size: 26px;">
                                                        {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, ['class' => 'name', 'data-parent' => $value->name, 'onclick' => 'checkChildPermissions(this)']) }}
                                                        <span class="title-highlight">{{ $value->name }}</span>
                                                    </label>
                                                    <br><br>
                        
                                                    <?php $permissions_chi = \Spatie\Permission\Models\Permission::where('parent', $value->id)->get(); ?>
                                                    <?php $permissions_chi_cont = \Spatie\Permission\Models\Permission::where('parent', $value->id)->count(); ?>
                        
                                                    @if ($permissions_chi_cont > 5)
                                                        <div class="row">
                                                            @foreach ($permissions_chi as $permissions_ch)
                                                                <div class="col-md-6">
                                                                    <div style="margin-right: 8%;">
                                                                        <label style="font-size: 14px; color: black;">
                                                                            {{ Form::checkbox('permission[]', $permissions_ch->id, in_array($permissions_ch->id, $rolePermissions) ? true : false, ['class' => 'name', 'data-children' => $value->name]) }}
                                                                            {{ $permissions_ch->name }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        @foreach ($permissions_chi as $permissions_ch)
                                                            <div style="margin-right: 8%;">
                                                                <label style="font-size: 14px; color: black;">
                                                                    {{ Form::checkbox('permission[]', $permissions_ch->id, in_array($permissions_ch->id, $rolePermissions) ? true : false, ['class' => 'name', 'data-children' => $value->name]) }}
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
                        
                    
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary btn-block">تحديث</button>
                    </div>
                    <!-- /col -->
               
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
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
