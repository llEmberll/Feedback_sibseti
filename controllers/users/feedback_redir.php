<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/path.php";

require_once BASE_DIR . "/models/feedback_inspector.php";

include_once BASE_DIR . "/models/notify/notify_warning.php";
include_once BASE_DIR . "/models/notify/notify_error.php";
include_once BASE_DIR . "/models/notify/notify_info.php";
include_once BASE_DIR . "/models/notify/notify_success.php";


/*
 * Набор инструментов для переадресации
 * данных с формы обращения
 */


function main()
{
    try {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $feedbackInspector = new FeedbackInspector(false);
            $resInspection = $feedbackInspector->inspection($_POST);
            if ($resInspection['success']) {
                $notify_success = new NotifySuccess($resInspection['message']);
                $notify_success->create();
            } else {
                $notify_error = new NotifyError($resInspection['message']);
                $notify_error->create();
            }
        }
    } catch (Throwable $e) {
        $notify_error = new NotifyError("Извините, что-то пошло не так, вернитесь к нам, пожалуйста, позднее");
        $notify_error->create();
    }

    include_once BASE_DIR . "/pages/feedback.php";

}

main();