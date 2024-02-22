<div class="modal" tabindex="-1" id="are_you_sure_modal">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-body bg-white">
                <h1>Are you sure?</h1>
                <form id="update_status_form" method="POST">
                    <input id="form_order_id" name="order_id" hidden>
                    <input id="form_status_id" name="status_id" hidden>
                    <input type="submit" class="btn btn-success" value="Yes">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="message_modal">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-body bg-success" id="message_modal_body">
                <h1>SUCCESSFULLY UPDATED STATUS!</h1>
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Ok</button>
            </div>
        </div>
    </div>
</div>