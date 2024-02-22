<div class="modal" tabindex="-1" id="add_update_product_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-white">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <div class="modal-body bg-white">
            <div id="modal_messages"></div>
            <form id="add_update_form">
            <div class="mb-3">
                <input type="text" class="form-control" name="product" id="modal_product" placeholder="Name">
            </div>

            <div class="mb-3">
                <textarea class="form-control" name="description" id="modal_description"></textarea>
            </div>

            <div class="mb-3 row mx-1">
                <select class="form-control col mx-1" name="category" id="modal_category">
                    <option value="">--- Select Category ---</option>
<?php           foreach($categories as $cat){
?>                  <option value="<?= $cat['id'] ?>"><?= $cat['category'] ?></option>
<?php           }
?>                  <option value="add_category_btn" class="bg-light" id="add_category_btn">
                        --Add Category--
                    </option>
                </select>
                <input type="text" class="form-control col mx-1" name="price" id="modal_price" placeholder="Price">
                <input type="text" class="form-control col mx-1" name="stock"  id="modal_stock" placeholder="Stocks">
            </div>

            <div id="new_category" class="my-2 me-4" hidden>
                    <input class="form-control d-inline-block w-25 mx-1" name="new_category" id="new_category" placeholder="Enter new category">
                    <button id="add_new_category" class="d-inline-block "> Add </button>
                    <button id="cancel_new_category" class="d-inline-block bg-warning"> Cancel </button>
            </div>

            <div class="mb-3">
                <label for="product" class="form-label">Images</label>
                <input type="file" id="modal_image" name="image[]" multiple/>
                <div id="update_frames" class="mb-1 row"></div>
                <div id="frames" class="mt-2 row"></div>
            </div>
            <div class="text-end">
                <input type="submit" id="submit_modal_btn" class="btn btn-success" >
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