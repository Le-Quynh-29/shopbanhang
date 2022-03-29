<div class="modal fade" id="modal-lock" tabindex="-1" role="dialog" aria-labelledby="modal-lock" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title_header }}</h5>
                <button type="button" class="close" data-coreui-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="body-title">{{ $title }}</div>
            </div>
            <div class="modal-footer">
                <div class="text-right">
                    <button type="submit" class="btn btn-primary btn-modal-save"> {{ $title_save }} </button>
                    <button type="button" class="btn btn-secondary btn-modal-cancel" data-coreui-dismiss="modal"> {{ $title_cancel }} </button>
                </div>
            </div>
        </div>
    </div>
</div>
