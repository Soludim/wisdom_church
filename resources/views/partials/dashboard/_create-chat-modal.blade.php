<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="chatmodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('chat.store') }}">
                @csrf()
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Create Chat</h4>
                </div>
                <div class="modal-body">
                    <p>Enter Chat Name</p>
                    <input type="text" name="name" value="{{old('name')}}" placeholder="Chat name" autocomplete="off" class="form-control placeholder-no-fix" />
                    @error('name')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                    <p style="margin-top: 15px">Chat Description</p>
                    <textarea rows="2" class="form-control" name="info">{{old('info')}}</textarea>
                    @error('info')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                    <input class="btn btn-theme" type="submit" value="Create" />
                </div>
            </form>
        </div>
    </div>
</div>