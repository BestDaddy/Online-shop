@extends('layouts.admin')

@section('content')
    {{--    {{ Breadcrumbs::render('user.index') }}--}}
    <h2>Корзина: </h2>
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
        <label id="total-price">Счет: </label>
    </div>

    <div class="modal fade" id="post-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Редактировать</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="Form" class="form-horizontal">
                        <input type="hidden" name="model_id" id="model_id">
                        <input type="hidden" name="item_id" id="item_id">
                        <input type="hidden" name="price" id="price">
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="inputName">Цена:  KZT</label>
                                            <input type="number"
                                                   class="form-control"
                                                   id="count"
                                                   name="count"
                                                   value="1"
                                                   min="1"
                                                   max="100">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="inputName">Всего:</label>
                                            <input type="number"
                                                   disabled
                                                   class="form-control"
                                                   id="total"
                                                   name="total">
                                        </div>
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
                            <button type="button" class="btn btn-primary" onclick="saveModel()">Добавить</button>
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
        $(document).ready(function() {
            $('#count').change(function(){
                ($('#total').val($('#price').val() * $('#count').val()));
            });
        });

        function total() {
            $.ajax({
                url: "{{ route('user.purchase-items.total') }}",
                type: "GET",
                success: function(response) {
                    if(response) {
                        console.log(response);
                        $('#total-price').text('Счёт: ' + response);
                    }
                }
            });
        }

        function deleteModel() {
            var id = $('#model_id').val();
            let _url = `/purchase-items/${id}`;
            let _token   = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: _url,
                type: 'DELETE',
                data: {
                    _token: _token
                },
                success: function(response) {
                    $('#table-model').DataTable().ajax.reload();
                    $('#post-modal').modal('hide');
                }
            });
        }

        function editModel (event) {
            $('#delete-button').show();
            $('#form-errors').html("");
            var id  = $(event).data("id");
            let _url = `/purchase-items/${id}/edit`;
            $.ajax({
                url: _url,
                type: "GET",
                success: function(response) {
                    if(response) {
                        $('#model_id').val(response.id);
                        $('#item_id').val(response.item.id);
                        $('#count').val(response.count);
                        $('#total').val(response.count * response.item.price);
                        $('#price').val(response.item.price);
                        $('#post-modal').modal('show');
                    }
                }
            });
        }

        function saveModel() {
            let _token   = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('user.purchase-items.store') }}",
                type: "POST",
                data: {
                    item_id: $('#item_id').val(),
                    count: $('#count').val(),
                    _token: _token
                },
                success: function(response) {
                    if(response.code == 200) {
                        // $('#model_id').val('')
                        $('#table-model').DataTable().ajax.reload();
                        total();
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
            total();
            $('#table-model').DataTable({
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
