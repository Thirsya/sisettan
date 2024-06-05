// proxy.php
<?php
header('Content-Type: application/javascript');
echo file_get_contents('https://cdn.jsdelivr.net/npm/altcha/dist/altcha.min.js');
