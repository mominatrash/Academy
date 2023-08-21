@can('تعديل الطلاب')
<a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_student" data-id="{{ $data->id }}"
    data-name="{{ $data->name }}"> <i class="fa fa-edit"> </i> تعديل  </a>
    @endcan



    @can('حذف الطلاب')
<a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_sstudent" data-id="{{ $data->id }}"> <i
        class="fa fa-trash">  </i>  حذف </a>
        @endcan
