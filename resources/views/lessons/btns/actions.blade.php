@can('تعديل الدروس')
    <a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_lesson" data-id="{{ $data->id }}"
        data-name="{{ $data->name }}" data-section_id={{ $data->section_id }} data-description={{ $data->description }}
        data-video_link={{ $data->video_link }} data-type={{ $data->type }}> <i class="fa fa-edit"> </i> تعديل </a>
@endcan



@can('حذف الدروس')
    <a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_lesson" data-id="{{ $data->id }}"> <i
            class="fa fa-trash"> </i> حذف </a>
@endcan
