@extends('layouts.admin')

@section('content')
    {{--    {{ Breadcrumbs::render('user.index') }}--}}
    <h2>Корзина </h2>
    <hr>
    <br>
    <div class="table-responsive">
        <table class=" table table-bordered table-striped" id="table-model" width="100%">
            <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="40%">Название</th>
                <th width="5%">Кол.</th>
                <th width="15%">Цена</th>
                <th width="20%">Дата</th>
{{--                --}}{{--                <th width="25%">Роль</th>--}}
                <th width="15%"></th>
{{--                <th width="15%"></th>--}}
            </tr>
            </thead>
        </table>
    </div>
    <br>
    <hr>
    <div class="align-right">
        <label>Счет: {{$total_price}}</label>
    </div>
@endsection


@section('scripts')
    <script>

        function editModel (event) {
            $('#delete-button').show();
            $('#staticBackdropLabel').text("Редактировать пользователя");
            $('#form-errors').html("");
            var id  = $(event).data("id");
            let _url = `/admin/items/${id}/edit`;
            $.ajax({
                url: _url,
                type: "GET",
                success: function(response) {
                    if(response) {
                        $('#model_id').val(response.id);
                        $('#name').val(response.name);
                        $('#order').val(response.order);
                        $('#price').val(response.price);
                        $('#image').val(response.image);
                        $('#description').val(response.description);
                        if(response.subcategory)
                            setSubcategories(response.subcategory.category_id, response.subcategory_id);
                        $('#select_subcategory').val(response.subcategory_id);
                        $('#post-modal').modal('show');
                    }
                }
            });
        }

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
                    url: "{{ route('user.purchase-items.index') }}",
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'item.name',
                        name: 'item.name'
                    },
                    {
                        data: 'count',
                        name: 'count'
                    },
                    {
                        data: 'item.price',
                        name: 'item.price'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'edit',
                        name: 'edit'
                    },
                    // {
                    //     data: 'more',
                    //     name: 'more'
                    // },
                ]
            });
        });
    </script>
@endsection
