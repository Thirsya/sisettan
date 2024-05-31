// proxy.php
<?php
header('Content-Type: application/javascript');
echo file_get_contents('https://eu.altcha.org/js/latest/altcha.min.js');
