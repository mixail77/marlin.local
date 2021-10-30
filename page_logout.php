<?php
if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/include/init.php')) {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/include/init.php');
}
logout();
?>