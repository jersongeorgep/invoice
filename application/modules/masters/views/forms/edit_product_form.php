<form method="POST" action="<?= site_url('masters/products/update_product/'.$product->id); ?>" enctype="multipart/form-data" id="productsForm">
    <div class="card-body row">
        <div class="form-group col-sm-4">
            <label for="products">Product <sup class="text-danger">*</sup></label>
            <input type="text" name="products" class="form-control" id="products" placeholder="Products" value="<?= $product->products; ?>">
        </div>
        <div class="form-group col-4">
            <label for="category_id">Category <sup class="text-danger">*</sup></label>
            <select name="category_id" id="category_id" class="form-control">
                <option value="">Select</option>
                <?php if($categories): foreach($categories as $val): ?>
                    <option value="<?= $val->id; ?>" <?= (($val->id == $product->category_id)?"selected":"");?>><?= $val->category_name; ?></option>
                <?php endforeach;  endif; ?>
            </select>
        </div>
        <div class="form-group col-4">
            <label for="unit_id">Unit <sup class="text-danger">*</sup></label>
            <select name="unit_id" id="unit_id" class="form-control">
                <option value="">Select</option>
                <?php if($units): foreach($units as $val): ?>
                    <option value="<?= $val->id; ?>" <?= (($val->id == $product->unit_id)?"selected":"");?> > <?= $val->name; ?></option>
                <?php endforeach;  endif; ?>
            </select>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
<script src="<?= site_url('assets/plugins/jquery-validation/jquery.validate.min.js'); ?>"></script>
<script src="<?= site_url('assets/plugins/jquery-validation/additional-methods.min.js'); ?>"></script>
<script>
    $(function() {
        $('input').attr('autocomplete','off');
        $('#productsForm').validate({
        rules: {
            products: {
                required: true
            },
            unit_id: {
                required: true
            }
        },
        messages: {
            products: {
                required: "Please enter products",
            },
            unit_id: {
                required: "Please choose units",
            }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
});
            </script>