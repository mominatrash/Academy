@extends('layouts.master')
@section('css')
    <!-- Internal Nice-select css  -->
    <link href="{{ URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet" />
    
    <link rel="stylesheet" type="text/css"
href="{{ asset('/app-assets/css/plugins/select2.min.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="https://troodon.mirmaz-apps.com/app-assets/vendors/css/forms/select/select2.min.css"> --}}
    
@section('title')
    اضافة مساعد
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
            <h5 class="content-title mb-0 my-auto">المساعدين</h5><span class="text-muted mt-0 tx-15 mr-1 mb-0">/ اضافة
                مساعد</span>
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
                </div><br>
                <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
                    action="{{ route('store_user') }}" method="post">
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="id" id="id">
                                <label>الاسم </label>
                                <div class="form-group">
                                    <input type="text" placeholder="name" name="name" id="name"
                                        class="form-control" />
                                    <span id="name_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>الايميل </label>
                                <div class="form-group">
                                    <input type="email" placeholder="email" name="email" id="email"
                                        class="form-control" />
                                    <span id="email_error" class="text-danger"></span>
                                </div>
                            </div>






                            <div class="col-md-6">
                                <label>الحالة </label>
                                <div class="form-group">


                                    <select class="form-select form-select-lg mb-3 form-control" name="status"
                                        id="status" aria-label=".form-select-lg example">

                                        <option selected>-------</option>
                                        <option value="مفعل">مفعل</option>
                                        <option value="غير مفعل">غير مفعل</option>

                                    </select>
                                    <span id="status_error" class="text-danger"></span>
                                </div>
                            </div>





                            <div class="col-md-6">
                                <label>كلمة السر </label>
                                <div class="form-group">
                                    <input type="password" placeholder="Password" name="password" id="password"
                                        class="form-control" />
                                    <span id="password_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="container" style="padding-top: 10px; margin-top: -28px;">
                                <div class="row main-container">
                                    <!-- Add the gap div on the left -->
                                    <div class="col-md-1 gap"></div>
                        
                                    <div class="col-md-10">
                                        <label>اسم الدور</label>
                                        <div class="form-group">
                                            <select class="select2 form-control" dir="rtl" name="roles_name[]" id="roles_name"
                                                 multiple="multiple">
                                                <?php $m = Spatie\Permission\Models\Role::all(); ?>
                                                @foreach ($m as $n)
                                                <option style="width: 36px;" value="{{ $n->name }}">{{ $n->name }}</option>
                                                @endforeach
                                            </select>
                                            {{-- <div>
                                                <label for="selected-values">Selected Values:</label>
                                                <div id="selected-values">
                                                    <!-- Selected values will be dynamically added here -->
                                                </div>
                                            </div> --}}
                                            <span id="roles_name_error" class="text-danger"></span>
                                        </div>
                                    </div>
                        
                                    <!-- Add the gap div on the right -->
                                    <div class="col-md-1 gap"></div>
                                </div>
                            </div>
                        


                        </div>

                    </div>
                    <div class="modal-footer">
                        {{-- <button type="submit" style="display: none" id="add_user2" class="btn btn-primary btn-block">تتم الاضافة ...</button> --}}
                        <button type="submit" id="add_user" class="btn btn-primary btn-block">اضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('scripts')

<script src="https://troodon.mirmaz-apps.com/app-assets/vendors/js/forms/select/select2.full.min.js"></script>


    <!-- Internal Nice-select js-->
    <script src="{{ URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js') }}"></script>

    <script src="https://troodon.mirmaz-apps.com/app-assets/js/scripts/forms/form-select2.js"></script>

    <!--Internal  Parsley.min js -->
    <script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{ URL::asset('assets/js/form-validation.js') }}"></script>

    
    
@endsection