<?php
require_once('../model/database.php');
require_once('../model/vehicles_db.php');
require_once('../model/makes_db.php');
require_once('../model/types_db.php');
require_once('../model/classes_db.php');

$action = filter_input(INPUT_POST, 'action', FILTER_UNSAFE_RAW);
if (!$action) {
    $action = filter_input(INPUT_GET, 'action', FILTER_UNSAFE_RAW);
    if (!$action) {
        $action = 'vehicles_list';
    }
}

switch ($action) {
    case 'vehicles_list':
    case 'vehicles_list_filtered': {
            $make_id = filter_input(INPUT_GET, 'make_id', FILTER_VALIDATE_INT);
            $type_id = filter_input(INPUT_GET, 'type_id', FILTER_VALIDATE_INT);
            $class_id = filter_input(INPUT_GET, 'class_id', FILTER_VALIDATE_INT);
            $sort_by = filter_input(INPUT_GET, 'sort_by', FILTER_UNSAFE_RAW);

            if ($make_id || $type_id || $class_id || $sort_by) {
                $filters = [];
                if ($make_id) {
                    $filters['make_id'] = $make_id;
                }
                if ($type_id) {
                    $filters['type_id'] = $type_id;
                }
                if ($class_id) {
                    $filters['class_id'] = $class_id;
                }
                $vehicles_list =  filterVehicles($sort_by, $filters);
            } else {
                $vehicles_list =  getVehicles();
            }

            $makes_list = get_makes();
            $types_list = get_types();
            $classes_list = get_classes();

            include('view/vehicles_list.php');
            break;
        }

    case 'add_vehicle_form': {
            $makes_list = get_makes();
            $types_list = get_types();
            $classes_list = get_classes();
            include('view/add_vehicle_form.php');
            break;
        }

    case 'add_vehicle': {
            $year = filter_input(INPUT_POST, 'year', FILTER_UNSAFE_RAW);
            $model = filter_input(INPUT_POST, 'model', FILTER_UNSAFE_RAW);
            $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
            $make_id = filter_input(INPUT_POST, 'make_id', FILTER_VALIDATE_INT);
            $type_id = filter_input(INPUT_POST, 'type_id', FILTER_VALIDATE_INT);
            $class_id = filter_input(INPUT_POST, 'class_id', FILTER_VALIDATE_INT);

            if ($year && $model && $price && $make_id && $type_id && $class_id) {
                $count =  add_vehicle($year, $model, $price, $make_id, $type_id, $class_id);
                header("Location: .?added_vehicle={$count}");
            } else {
                $error_message = 'Invalid Data';
                include('view/error.php');
            }

            break;
        }

    case 'delete_vehicle': {
            $year = filter_input(INPUT_POST, 'year', FILTER_UNSAFE_RAW);
            $model = filter_input(INPUT_POST, 'model', FILTER_UNSAFE_RAW);
            $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
            $make_id = filter_input(INPUT_POST, 'make_id', FILTER_VALIDATE_INT);
            $type_id = filter_input(INPUT_POST, 'type_id', FILTER_VALIDATE_INT);
            $class_id = filter_input(INPUT_POST, 'class_id', FILTER_VALIDATE_INT);

            $ids = array(
                "make_id" => $make_id,
                "type_id" => $type_id,
                "class_id" => $class_id
            );

            if ($year && $model && $price) {
                $count =  delete_vehicle($year, $model, $price, $ids);
                header("Location: ./?deleted_vehicle={$count}");
            } else {
                $error_message = 'Invalid Data';
                include('view/error.php');
            }
            break;
        }

    case 'makes_list': {
            $makes_list = get_makes();
            include('view/makes_list.php');
            break;
        }

    case 'add_make': {
            $make_name = filter_input(INPUT_POST, 'make_name', FILTER_UNSAFE_RAW);
            if ($make_name) {
                $count = add_make($make_name);
                header("Location: .?action=makes_list&added_make={$count}");
            } else {
                $error_message = 'Invalid Make';
                include('view/error.php');
            }
            break;
        }

    case 'delete_make': {
            $make_id = filter_input(INPUT_POST, 'make_id', FILTER_VALIDATE_INT);
            if ($make_id) {
                $count = delete_make($make_id);
                header("Location: .?action=makes_list&deleted_make={$count}");
            } else {
                $error_message = 'Invalid Make';
                include('view/error.php');
            }
            break;
        }
    case 'types_list': {
            $types_list = get_types();
            include('view/types_list.php');
            break;
        }

    case 'add_type': {
            $type_name = filter_input(INPUT_POST, 'type_name', FILTER_UNSAFE_RAW);
            if ($type_name) {
                $count = add_type($type_name);
                header("Location: .?action=types_list&added_type={$count}");
            } else {
                $error_message = 'Invalid Type';
                include('view/error.php');
            }
            break;
        }

    case 'delete_type': {
            $type_id = filter_input(INPUT_POST, 'type_id', FILTER_VALIDATE_INT);
            if ($type_id) {
                $count = delete_type($type_id);
                header("Location: .?action=types_list&deleted_type={$count}");
            } else {
                $error_message = 'Invalid Type';
                include('view/error.php');
            }
            break;
        }
}
