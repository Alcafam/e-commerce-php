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
                <input type="text" class="form-control" name="product" id="product" placeholder="Name">
            </div>

            <div class="mb-3">
                <textarea class="form-control" name="description" id="description"></textarea>
            </div>

            <div class="mb-3 row mx-1">
                <select class="form-control col d-inline-block mx-1" name="category" id="category">
                    <option value="">--- Select Category ---</option>
<?php           foreach($categories as $cat){
?>                  <option value="<?= $cat['id'] ?>"><?= $cat['category'] ?></option>
<?php           }
?>                  <option>
                        <button>-- Add Category--</button>
                    </option>
                </select>
                <input type="text" class="form-control col d-inline-block mx-1" name="price" id="price" placeholder="Price">
                <input type="text" class="form-control col d-inline-block mx-1" name="stock"  id="stock" placeholder="Stocks">
            </div>

            <div class="mb-3">
                <label for="product" class="form-label">Images</label>
                <input type="file" id="image" name="image[]" multiple/>
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
        <div class="modal-content bg-succes text-center text-white">
            <div class="modal-body bg-white" id="message_modal_body">
                
            </div>
        </div>
    </div>
</div>