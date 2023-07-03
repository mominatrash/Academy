<a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_course" data-id="{{ $data->id }}"
    data-name="{{ $data->name }}" 
    data-description = "{{ $data->description }}"
    data-level_id = "{{ $data->level_id }}"
    data-is_free = "{{ $data->is_free }}"
    data-image = "{{ $data->image }}"
     > <i class="fa fa-edit"> </i> تعديل  </a>




<a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_course" data-id="{{ $data->id }}"> <i
        class="fa fa-trash">  </i>  حذف </a>
