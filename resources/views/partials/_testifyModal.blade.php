<div aria-hidden="true" aria-labelledby="testimonyModal" role="dialog" tabindex="-1" id="testifyModal" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Testimony</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form method="post" action="{{ route('testimonies.store') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <textarea rows="4" name="content" maxlength="200" required placeholder="Testify to the goodness of God..." autocomplete="off" class="form-control placeholder-no-fix"></textarea>
                </div>
                <div class="modal-footer">
                    <input class="btn btn-default" type="submit" value="Submit"/>
                </div>
            </form>
        </div>
    </div>
</div>
