@can('تعديل الاختبارات')
    <a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_quiz" data-id="{{ $data->id }}"
        data-name="{{ $data->name }}" data-lesson_id={{ $data->lesson_id }} data-type={{ $data->type }}
        data-input_type={{ $data->input_type }} data-points={{ $data->points }} data-time={{ $data->time }}
        data-questions_number={{ $data->questions_number }} data-attempts={{ $data->attempts }}
        data-deduction_per_attempt={{ $data->deduction_per_attempt }} data-notes={{ $data->notes }}> <i class="fa fa-edit">
        </i> تعديل </a>
@endcan



@can('حذف الاختبارات')
    <a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_quiz" data-id="{{ $data->id }}"> <i
            class="fa fa-trash"> </i> حذف </a>
@endcan
