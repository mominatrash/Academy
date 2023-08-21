@can('تعديل المراحل')
    <a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_level" data-id="{{ $data->id }}"
        data-name="{{ $data->name }}" data-subject_id={{ $data->subject_id }}> <i class="fa fa-edit"> </i> تعديل </a>
@endcan



@can('حذف المراحل')
    <a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_level" data-id="{{ $data->id }}"> <i
            class="fa fa-trash"> </i> حذف </a>
@endcan
