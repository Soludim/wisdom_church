<div aria-hidden="true" aria-labelledby="deleteChatModal" role="dialog" tabindex="-1" id="deleteChat" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('chat.destroy', $data->id) }}">
                @csrf()
                @method('delete')
                <div class="modal-header">
                    <h4 class="modal-title">Turn Off Member Chat</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <p style="color: black; font-weight: bold; text-align: center">Are you sure you want to permanently delete this chat?</p>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">No</button>
                    <input class="btn btn-theme" type="submit" value='Yes' />
                </div>
            </form>
        </div>
    </div>
</div>