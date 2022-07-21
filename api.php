<?php
header('Access-Control-Allow-Origin: *');

require('./endpoints.php');

if (isset($_GET["action"])) {
    header('Content-Type: application/json; charset=utf-8');

    switch ($_GET["action"]) {
        case "getBatches":
            echo json_encode(getAllBatches());
            break;
        case "getBatchDetails":
            echo json_encode(getBatchDetails($_GET['batch_id']));
            break;

        case "getTopicDetails":
            echo json_encode(getTopicDetails($_GET['batch_id'], $_GET['subject_id']));
            break;


        case "getSubTopicDetails":
            echo json_encode(getSubTopicDetails($_GET['batch_id'], $_GET['subject_id'], $_GET['tag'], $_GET['type']));
            break;
    }
}
