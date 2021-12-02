@extends('layouts.admin')

@section('content')
    {{--    {{ Breadcrumbs::render('user.index') }}--}}
    <h2>Все товары</h2>
    <hr>
    <br>
    <div class="row" style="clear: both;">
        <div class="col-12 text-right">
            <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" onclick="add()"><i class="fas fa-plus-square"></i> Добавить пользователя</a>
        </div>
    </div>
    <br>
    <div class="table-responsive">
        <table class=" table table-bordered table-striped" id="table-model" width="100%">
            <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="40%">Имя</th>
                {{--                <th width="25%">Роль</th>--}}
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
                    <h5 class="modal-title" id="staticBackdropLabel">Новый пользователь</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="Form" class="form-horizontal">
                        <input type="hidden" name="model_id" id="model_id">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Название</label>
                                    <input type="text"
                                           class="form-control"
                                           id="name"
                                           name="name">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="order">Порядок</label>
                                    <input type="number"
                                           class="form-control"
                                           id="order"
                                           name="order">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="order">Цена</label>
                                    <input type="number"
                                           class="form-control"
                                           id="price"
                                           name="price">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Описание</label>
                            <textarea class="form-control"
                                      id="description"
                                      name="description"
                                      rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Картинка</label>
                            <input type="text" class="form-control"
                                   id="image"
                                   name="image">
                        </div>
                        <div class="form-group">
                            <label>Категорию</label>
                            <select name="select_category" id="select_category" class="form-control">
                                <option disabled selected>Выбирите категорию</option>
                                {{--                                @foreach($categories as $category)--}}
                                {{--                                    <option value="{{$category->id}}">{{$category->name}}</option>--}}
                                {{--                                @endforeach--}}
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Подкатегорию</label>
                            <select name="select_subcategory" id="select_subcategory" class="form-control">
                                <option disabled selected>Выбирите подкатегорию</option>
                            </select>
                        </div>

                        <div class="form-group" id="form-errors">
                            <div class="alert alert-danger">
                                <ul>

                                </ul>
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
        var categories = [];
        $(document).ready(function() {
            $.ajax({
                url: `{{route('admin.categoriesWithSubcategories')}}`,
                type: "GET",
                success: function(response) {
                    if(response) {
                        categories = response;
                        html = '';
                        html += '<option disabled selected>Выбирите категорию</option>';
                        $.each(response, function( i ) {
                            html += '<option value="'+ response[i].id+'">'+response[i].name+'</option>';
                        });
                        $( '#select_category' ).html( html );
                    }
                }
            });

            $('#select_category').change(function(){
                setSubcategories($('#select_category').val());
            });
        });

        function setSubcategories(category_id, subcategory_id = null) {
            $('#select_category').val(category_id)
            html = '';
            $.each( categories, function( i ) {
                if(categories[i].id == category_id){
                    subcategories = categories[i].subcategories;
                }
            });
            html += '<option disabled selected>Выбирите подкатегорию</option>';
            $.each( subcategories, function( i ) {
                if(subcategories[i].id === subcategory_id)
                    html += '<option selected value="'+ subcategories[i].id+'">'+subcategories[i].name+'</option>';
                else
                    html += '<option value="'+ subcategories[i].id+'">'+subcategories[i].name+'</option>';
            });
            $( '#select_subcategory' ).html( html );
        }

        function add() {
            $('#model_id').val('')
            $('#name').val('')
            $('#order').val('')
            $('#description').val('')
            $('#select_category').val('')
            $('#select_subcategory').val('')
            $('#form-errors').html('');
            $('#collapseExample').hide();
            $('#post-modal').modal('show');

        }

        function deleteModel() {
            var id = $('#model_id').val();
            let _url = `/admin/items/${id}`;
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
        function saveModel() {
            let _token   = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('admin.items.store') }}",
                type: "POST",
                data: {
                    id: $('#model_id').val(),
                    name: $('#name').val(),
                    order: $('#order').val(),
                    price: $('#price').val(),
                    image: $('#image').val(),
                    description: $('#description').val(),
                    subcategory_id: $('#select_subcategory').val(),
                    _token: _token
                },
                success: function(response) {
                    if(response.code == 200) {
                        $('#model_id').val('')
                        $('#name').val('');
                        $('#order').val('');
                        $('#price').val(0);
                        $('#image').val(''),
                            $('#description').val(2);
                        $('#select_subcategory').val('');
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
                // aoColumnDefs: [
                //     { "sClass": "my_class", "aTargets": [ 0 ] }
                // ],
                language: {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json"
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.purchases.index') }}",
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
