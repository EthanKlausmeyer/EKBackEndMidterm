<?php
require_once('model/database.php');
require_once('model/vehicles_db.php');
require_once('model/makes_db.php');
require_once('model/types_db.php');
require_once('model/classes_db.php');

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
            $sort_by = filter_input(INPUT_GET, 'sort_by', FILTER_UNSAFE_RAW) ?? 'price';

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
}
