@extends('layouts.admin')

@section('content')
    {{--    {{ Breadcrumbs::render('user.index') }}--}}
    <h2>Все товары</h2>
    <hr>
    <br>
    <div class="row" style="clear: both;">
        <div class="col-12 text-right">
            <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" onclick="postModal()">
                <i class="fas fa-plus-square"></i> Создать
            </a>
        </div>
    </div>
    <br>
    <div class="table-responsive">
        <table class=" table table-bordered table-striped" id="table-model" width="100%">
            <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="55%">Title</th>
                <th width="10%">Order</th>
                <th width="15%"></th>
                <th width="15%"></th>
            </tr>
            </thead>
        </table>
    </div>
    <br>
    <hr>
    <div class="modal fade" id="post-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Создать</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="Form" class="form-horizontal">
                        <input type="hidden" name="model_id" id="model_id">
                        <div class="row">
                            <div class="col">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="name">Название</label>
                                        <input type="text"
                                               class="form-control"
                                               id="name"
                                               name="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="order">Порядок</label>
                                        <input type="number"
                                               class="form-control"
                                               id="order"
                                               name="order">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="form-errors">
                            <div class="alert alert-danger">
                                <ul></ul>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-1" role="group" aria-label="Second group">
                            <div class="collapse" id="delete-button">
                                <button type="button" class="btn btn-danger" onclick="deleteModel()">Удалить</button>
                            </div>
                        </div>
                        <div class="btn-group" role="group" aria-label="Third group">
                            <button type="button" class="btn btn-primary" onclick="saveModel()">Сохранить</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        function postModal() {
            $('#form-errors').html("");
            $('#delete-button').hide();
            $('#staticBackdropLabel').text("Создать");
            $('#post-modal').modal('show');
        }

        function deleteModel() {
            var id = $('#model_id').val();
            let _url = `/users/${id}`;

            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: 'DELETE',
                data: {
                    _token: _token
                },
                success: function(response) {
                    $('#user_table').DataTable().ajax.reload();
                    $('#post-modal').modal('hide');
                }
            });
        }

        function editModel (event) {
            $('#delete-button').show();
            $('#staticBackdropLabel').text("Редактировать");
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
                        $('#post-modal').modal('show');
                    }
                }
            });
        }
        function saveModel() {
            var id = $('#model_id').val();
            var name = $('#name').val();
            var order = $('#order').val();
            let _token   = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('admin.subcategories.store') }}",
                type: "POST",
                data: {
                    id: id,
                    name: name,
                    order: order,
                    category_id: '{{ $params['category_id'] }}',
                    _token: _token
                },
                success: function(response) {
                    if(response.code == 200) {
                        $('#user_id').val('');
                        $('#table-model').DataTable().ajax.reload();
                        $('#post-modal').modal('hide');
                    }
                    else{
                        var errors = response.errors;
                        errorsHtml = '<div class="alert alert-danger"><ul>';

                        $.each( errors, function( key, value ) {
                            errorsHtml += '<li>'+ value + '</li>'; //showing only the first error.
                        });
                        errorsHtml += '</ul></div>';

                        $( '#form-errors' ).html( errorsHtml ); //appending to a <div id="form-errors"></div> inside form

                    }
                },
                error: function(response) {
                    $('#nameError').text(response.responseJSON.errors.name);
                }
            });
        }
        $(document).ready(function() {

            $('#table-model').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json"
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.categories.show', $params['category_id']) }}",
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'order',
                        name: 'order'
                    },
                    {
                        data: 'edit',
                        name: 'edit'
                    },
                    {
                        data: 'more',
                        name: 'more'
                    },
                ]
            });
        });
    </script>
@endsection
