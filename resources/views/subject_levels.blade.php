@extends('layouts.master')


@section('css')
@endsection



@section('title')
    لوحة التحكم
@endsection



@section('content')
    <h1>مراحل المادة</h1>
    {{-- <p>إسم المادة: {{ $subject->name }}</p> --}}

    <table id="subject-levels-table" class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>إسم المرحلة</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@endsection


@section('scripts')
<script>
    $(document).ready(function() {
        var subjectId = {{ $subject->id }}; // Assuming you have the $subject variable available in your view

        $('#subject-levels-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('subject_levels_data', ['subject' => ':subject']) }}",
                data: function (data) {
                    data.subject = subjectId;
                }
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        // Auto-increment the ID column starting from 1
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'action'
                },
            ],
            "lengthMenu": [
                [5, 25, 50, -1],
                [5, 25, 50, 'All']
            ], // page length options
        });
    });
</script>

@endsection
