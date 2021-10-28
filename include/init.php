<?php
session_start();
if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/include/constants.php')) {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/include/constants.php');
}
if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/include/functions.php')) {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/include/functions.php');
}
?>