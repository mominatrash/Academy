@extends('layouts.master')

@section('css')
<!-- Internal jstree CSS -->
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/jstree/jstree.min.css') }}">
<style>
    /* Custom styles for the treeview */
    .jstree-default .jstree-leaf > .jstree-anchor > .jstree-icon {
        display: none;
    }

    .jstree-default .jstree-anchor {
        padding-left: 20px;
    }

    /* Custom styles for the permissions list */
    .permissions-container {
        display: flex;
        flex-wrap: wrap;
        max-height: 400px; /* Add a max height and scrollbar for the permissions list */
        overflow-y: auto;
        padding: 5px; /* Add padding to the container to center the permissions */
        margin-right: 100px;
    }

    .permission-card {
        flex-basis: 20%; /* Show five items per row */
        padding: 10px;
        border: 1px solid #e9ecef;
        border-radius: 4px;
        margin: 5px;
        background-color: #f8f9fa;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center; /* Center the content both horizontally and vertically */
        height: 100%; /* Ensure the card takes the full height */
        color: black;
    }

    /* Custom styles for the search box */
    .search-box {
        margin-top: 20px;
        width: 100%;
    }

    .form-control {
        width: 100%;
    }
</style>
@endsection

@section('title')
    عرض صلاحيات المساعد
@endsection

@section('content')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between" style="padding: 20px; font-size: 15px;">
    <div class="my-auto">
        <div class="d-flex">
            <a href="{{ route('show_roles') }}"class="content-title mb-0 my-auto">الصلاحيات</a>
            <span class=" mt-0 tx-13 mr-2 mb-0">/ عرض الصلاحيات</span>
        </div>
    </div>
</div>

<br>
<br>
<br>

<!-- breadcrumb -->

<!-- Container -->
<div class="container">
    <!-- Row -->
    <div class="row justify-content-center">
        <div class="col-md-8"> <!-- Removed the default margin -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-6">صلاحيات دور {{ $role->name }}</h5>
                    <!-- Search Box -->
                    <div class="search-box">
                        <input type="text" class="form-control" id="searchPermission" placeholder="ابحث عن صلاحية...">
                    </div>
                    <br>
                    <!-- Permissions List -->
                    <div id="treeview">
                        <div class="permissions-container">
                            @if(!empty($rolePermissions))
                                @foreach($rolePermissions as $v)
                                    <div class="permission-card">
                                        <div class="d-flex align-items-center" style="height: 100%;">
                                            {{ $v->name }}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="text-end mt-4">
                        <a class="btn btn-primary btn-md" href="{{ route('show_roles') }}">رجوع</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
</div>
<!-- /Container -->
@endsection

@section('scripts')
<!-- Internal jstree JS -->
<script src="{{ URL::asset('assets/plugins/jstree/jstree.min.js') }}"></script>
<script>
    // Initialize the jstree plugin
    $(function() {
        $('#treeview').jstree({
            "core": {
                "themes": {
                    "variant": "large"
                }
            },
            "plugins": ["wholerow"]
        });
    });

    // Filter permissions based on search
    $("#searchPermission").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".permission-card").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
</script>
@endsection
