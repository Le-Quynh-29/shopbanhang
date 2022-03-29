<div class="modal fade" id="{{ $id_modal }}">
    <div class="modal-dialog {{ $modal_lg }}" role="document">
        <div class="modal-content">
            <form method="post" action="{{ $route }}" id="{{ $model }}" enctype="multipart/form-data"
                  class="form form-horizontal">
                @csrf
                <input type="hidden" name="_method" value="{{ $method }}"/>
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title_header }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ $data }}
                </div>
                <div class="modal-footer">
                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-primary btn-modal-save" id="modal-form-create"> {{ $title_save }} </button>
                        <button type="button" class="btn btn-secondary btn-modal-cancel" data-dismiss="modal"> {{ $title_cancel }} </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
