@extends('layouts.admin')

@section('content')
    <div class="row" style="clear: both;">
        <div class="col-8 text-right ml-auto">
            <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" onclick="postModal()"><i class="fas fa-plus-square"></i> Купить</a>
        </div>
    </div>
    <div class="card bg-dark text-dark">
{{--        <img src="..." class="card-img" alt="...">--}}
        <div class="card-img-overlay">
            <h4 class="card-title">{{$item->name}}</h4>
            <img class="card-img-top img-fluid" src="{{$item->image ?? 'https://aseshop.kz/uploads/default/no-image.jpg'}}" alt="Card image">
            <h5 class="card-title">{{data_get($item, 'subcategory.name')}}</h5>
            <p class="card-text">{{$item->description}}</p>
            <p class="card-text">{{$item->created_at->diffForHumans()}}</p>
        </div>
    </div>

    <div class="modal fade" id="post-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{$item->name}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="Form" class="form-horizontal">
                        <input type="hidden" name="model_id" id="model_id" value="{{$item->id}}">
                        <input type="hidden" name="price" id="price" value="{{$item->price}}">
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="inputName">Цена: {{$item->price}} KZT</label>
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
                                                   name="total"
                                                   value="{{$item->price}}">
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
        function postModal() {
            $('#form-errors').html('');
            // $('#staticBackdropLabel').text("Купить");
            $('#post-modal').modal('show');
        }

        function saveModel() {
            let _token   = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('user.purchases.addItem') }}",
                type: "POST",
                data: {
                    item_id: $('#model_id').val(),
                    count: $('#count').val(),
                    _token: _token
                },
                success: function(response) {
                    if(response.code == 200) {
                        // $('#model_id').val('')
                        // $('#name').val('');
                        // $('#order').val('');
                        // $('#price').val(0);
                        // $('#image').val(''),
                        //     $('#description').val(2);
                        // $('#select_subcategory').val('');
                        // $('#table-model').DataTable().ajax.reload();
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
    </script>
@endsection
