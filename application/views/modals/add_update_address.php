<div class="modal" tabindex="-1" id="add_update_address_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-white">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title"></h5>
                <button type="button" class="btn-close bg-danger text-black" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <div class="modal-body bg-white">
            <div id="modal_messages"></div>
            <form id="add_update_form" method="POST">
                <div class="mb-3">
                    <label for="modal_house" class="form-label">House #</label>
                    <input type="text" class="form-control" name="house" id="modal_house" >
                </div>
                <div class="mb-3">
                    <label for="modal_street" class="form-label">Street</label>
                    <input type="text" class="form-control" name="street" id="modal_street" >
                </div>
                <div class="mb-3">
                    <label for="modal_barangay" class="form-label">Barangay *</label>
                    <input type="text" class="form-control" name="barangay" id="modal_barangay" >
                </div>
                <div class="mb-3">
                    <label for="modal_city" class="form-label">City *</label>
                    <input type="text" class="form-control" name="city" id="modal_city" >
                </div>
                <div class="mb-3">
                    <label for="modal_province" class="form-label">Province *</label>
                    <input type="text" class="form-control" name="province" id="modal_province" >
                </div>
                <div class="mb-3">
                    <label for="modal_zipcode" class="form-label">Zipcode *</label>
                    <input type="text" class="form-control" name="zipcode" id="modal_zipcode" >
                </div>
                <div class="text-end">
                    <input type="submit" id="submit_modal_btn" class="btn btn-success">
                </div>
            </form>
        </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="message_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body bg-white text-center" id="message_modal_body">
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Ok</button>
            </div>
        </div>
    </div>
</div>