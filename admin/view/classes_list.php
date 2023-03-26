<?php include('view/header.php'); ?>
<section class="classes_list">
    <h2 class="text-primary">Vehicle Classes</h2>
    <div class="table_container table-responsive">
        <?php if (!empty($classes_list)) { ?>
            <table class="table table-hover align-middle">
                <tr>
                    <th>Name</th>
                    <th></th>
                </tr>

                <?php foreach ($classes_list as $class) { ?>
                    <tr>
                        <td><?= $class->getName() ?></td>
                        <td>
                            <form action="." METHOD="POST" class="delete_form text-end">
                                <input type="hidden" name="action" value="delete_class">
                                <input type="hidden" name="class_id" value="<?= $class->getID() ?>">
                                <button class="btn btn-sm btn-danger ">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p class="message">No Classes Exist</p>
        <?php } ?>
    </div>

    <h2 class="text-primary">Add Vehicle Class</h2>
    <form action="." method="POST" class="add_form">
        <div class="container">
            <input type="hidden" name="action" value="add_class">
            <div class="form_group my-2 row">
                <label for="class_name" class="form_label px-0">Name: </label>
                <input class="form_field" type="text" name="class_name" id="class_name" maxlength="100" autocomplete="off" aria-required="true" required>
            </div>
            <div class="form_group my-2 row">
                <div></div>
                <button class="btn btn-outline-primary">Add Class</button>
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