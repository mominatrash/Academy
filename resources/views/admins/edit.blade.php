@extends('layouts.master')

@section('css')
    <!-- Internal Nice-select css  -->
    <link href="{{ URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet" />

    <link rel="stylesheet" type="text/css"
href="{{ asset('/app-assets/css/plugins/select2.min.css') }}">

    <style>
        /* Custom styles for the form layout */
        .form-label {
            font-weight: bold;
        }

        .btn-submit {
            background-color: #007bff;
            color: #fff;
        }

        .btn-back {
            background-color: #ccc;
            color: #000;
        }

        .mg-b-20 {
            margin-bottom: 20px;
        }

        .mg-t-30 {
            margin-top: 30px;
        }

        .form-control[readonly] {
            background-color: #f5f5f5;
        }

        .tx-danger {
            color: #ff0000;
        }

    </style>
@endsection

@section('title')
تعديل المساعد
@endsection

@section('page-header')
    <!-- breadcrumb -->

    <!-- breadcrumb -->
@endsection

@section('content')


<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h5 class="content-title mb-0 my-auto">المساعدين</h5><span class="text-muted mt-0 tx-15 mr-1 mb-0">/ تعديل
                المساعد</span>
        </div>
    </div>
</div>

<br>
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">

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

            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('show_admins') }}">رجوع</a>
                        </div>
                    </div>
                    <br>
            
                    {!! Form::model($user, ['method' => 'POST', 'route' => ['update_user', $user->id]]) !!}
                    <div class="">
                        <div class="row mg-b-20">
                            <div class="col-md-6">
                                <label class="form-label">اسم المستخدم: <span class="tx-danger">*</span></label>
                                {!! Form::hidden('id', $user->id) !!}
                                {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                            </div>
            
                            <div class="col-md-6 mg-t-20 mg-md-t-0">
                                <label class="form-label">البريد الالكتروني: <span class="tx-danger">*</span></label>
                                {!! Form::text('email', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                        </div>
            
                        <div class="row mg-b-20">
                            <div class="col-md-6 mg-t-20 mg-md-t-0">
                                <label class="form-label">كلمة المرور: <span class="tx-danger">*</span></label>
                                {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
                            </div>
            
                            <div class="col-md-6 mg-t-20 mg-md-t-0">
                                <label class="form-label">تاكيد كلمة المرور: <span class="tx-danger">*</span></label>
                                {!! Form::password('confirm-password', ['class' => 'form-control', 'required']) !!}
                            </div>
                        </div>
            
                        <div class="row row-sm mg-b-20">
                            <div class="col-lg-6">
                                <label class="form-label">حالة المستخدم: <span class="tx-danger">*</span></label>
                                <select name="status" id="select-beast" class="form-control nice-select custom-select">
                                    <option value="{{ $user->status }}">{{ $user->status }}</option>
                                    @if ($user->status == 'مفعل')
                                    <option value="غير مفعل">غير مفعل</option>
                                    @else
                                    <option value="مفعل">مفعل</option>
                                    @endif
                                </select>
                            </div>
            
                            <div class="col-lg-6">
                                <label class="form-label">اسم الدور: <span class="tx-danger">*</span></label>
                                <div class="form-group">
                                    <select class="select2 form-control" dir="rtl" name="roles_name[]" id="roles_name"
                                        multiple="multiple">
                                        <?php $m = Spatie\Permission\Models\Role::all(); ?>
                                        @foreach ($m as $n)
                                        <option style="width: 36px;" value="{{ $n->name }}">{{ $n->name }}</option>
                                        @endforeach
                                    </select>
                                    <span id="roles_name_error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
            
                        <div class="row mg-t-30">
                            <div class="col-md-12">
                                <button class="btn btn-primary btn-block pd-x-20" type="submit">تحديث</button>
                            </div>
                        </div>
                        
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            </div>
            
    <!-- row closed -->
@endsection

@section('scripts')
    <!-- Internal Nice-select js-->
    <script src="https://troodon.mirmaz-apps.com/app-assets/vendors/js/forms/select/select2.full.min.js"></script>

    <script src="{{ URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js') }}"></script>

    <script src="https://troodon.mirmaz-apps.com/app-assets/js/scripts/forms/form-select2.js"></script>


    <!--Internal Parsley.min js -->
    <script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{ URL::asset('assets/js/form-validation.js') }}"></script>
@endsection
