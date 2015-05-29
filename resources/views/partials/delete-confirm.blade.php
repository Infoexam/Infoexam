<div class="modal" id="delete-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ trans('general.delete.confirm') }}</h4>
            </div>
            <div class="modal-body text-danger">
                <div>
                    <p>{{ trans('general.attention') }}：</p>
                    <ul>
                        <li>{{ trans('general.irreversible') }}</li>
                        <li>{{ trans('general.related', ['action' => trans('general.delete.passive')]) }}</li>
                    </ul>
                </div>
                <div>
                    {!! HTML::recaptcha() !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-confirm-delete>{{ trans('general.yes') }}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('general.no') }}</button>
            </div>
        </div>
    </div>
</div>