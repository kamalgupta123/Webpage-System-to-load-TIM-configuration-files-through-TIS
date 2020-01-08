<?php
    
    $junction = $_POST['junction'];
    exec("python /var/www/html/config.py ".$junction,$output,$return_var);
    echo $output[1];
?>