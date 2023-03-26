<?php include('view/header.php'); ?>
<section class="types_list">
    <h2 class="text-primary">Vehicle Type List</h2>
    <div class="table_container table-responsive">
        <?php if (!empty($types_list)) { ?>
            <table class="table table-hover align-middle">
                <tr>
                    <th>Name</th>
                    <th></th>
                </tr>

                <?php foreach ($types_list as $type) { ?>
                    <tr>
                        <td><?= $type->getName() ?></td>
                        <td>
                            <form action="." METHOD="POST" class="delete_form text-end">
                                <input type="hidden" name="action" value="delete_type">
                                <input type="hidden" name="type_id" value="<?= $type->getID() ?>">
                                <button class="btn btn-sm btn-danger ">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p class="message">No Vehicle Type exist yet.</p>
        <?php } ?>
    </div>

    <h2 class="text-primary">Add Vehicle Type</h2>
    <form action="." method="POST" class="add_form">
        <div class="container">
            <input type="hidden" name="action" value="add_type">
            <div class="form_group my-2 row">
                <label for="type_name" class="form_label px-0">Name: </label>
                <input class="form_field" type="text" name="type_name" id="type_name" maxlength="100" autocomplete="off" aria-required="true" required>
            </div>
            <div class="form_group my-2 row">
                <div></div>
                <button class="btn btn-outline-primary">Add Type</button>
            </div>
        </div>
    </form>
    <?php
    $added_make = filter_input(INPUT_GET, 'added_make', FILTER_VALIDATE_INT);
    $added_type = filter_input(INPUT_GET, 'added_type', FILTER_VALIDATE_INT);
    $added_class = filter_input(INPUT_GET, 'added_class', FILTER_VALIDATE_INT);

    if (isset($added_make) && $added_make == 0) {
        echo '<p class="status text-danger">Duplicate make entry</p>';
    }
    if (isset($added_type) && $added_type == 0) {
        echo '<p class="status text-danger">Duplicate type entry</p>';
    }
    if (isset($added_class) && $added_class == 0) {
        echo '<p class="status text-danger">Duplicate class entry</p>';
    }
    ?>
</section>
<?php include('view/footer.php'); ?>