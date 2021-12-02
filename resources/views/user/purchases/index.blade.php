@extends('layouts.admin')

@section('content')
    {{--    {{ Breadcrumbs::render('user.index') }}--}}
    <h2>Корзина</h2>
    <hr>
    <br>
    <div class="table-responsive">
        <table class=" table table-bordered table-striped" id="table-model" width="100%">
            <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="40%">Дата</th>
{{--                --}}{{--                <th width="25%">Роль</th>--}}
{{--                <th width="15%"></th>--}}
{{--                <th width="15%"></th>--}}
            </tr>
            </thead>
        </table>
    </div>
    <br>
    <hr>
@endsection


@section('scripts')
    <script>

        $(document).ready(function() {

            $('#table-model').DataTable({
                // aoColumnDefs: [
                //     { "sClass": "my_class", "aTargets": [ 0 ] }
                // ],
                language: {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json"
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('user.purchases.index') }}",
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    // {
                    //     data: 'edit',
                    //     name: 'edit'
                    // },
                    // {
                    //     data: 'more',
                    //     name: 'more'
                    // },
                ]
            });
        });
    </script>
@endsection
