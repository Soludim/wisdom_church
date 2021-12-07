<div aria-hidden="true" aria-labelledby="prayerRequestModal" role="dialog" tabindex="-1" id="requestModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Prayer Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form method="post" action="{{ route('prayer_store') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <textarea rows="4" name="content" required placeholder="request body here..." autocomplete="off" class="form-control placeholder-no-fix"></textarea>
                    <p style="color:grey">Prayer request is anonymous, we won't get to know who sent it. You can include your name in the content if you want us to know.</p>
                </div>
                <div class="modal-footer">
                    <input class="btn btn-default" type="submit" value="Submit"/>
                </div>
            </form>
        </div>
    </div>
</div>