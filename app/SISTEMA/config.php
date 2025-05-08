<?php
//Conexão com o banco de dados
$HOST_DATABASE = '172.17.0.1';
$USER_DATABASE = 'root';
$PASS_DATABASE = 'root';
$DATABASE_NAME = 'pi_tres';

try {
    $connection = new mysqli($HOST_DATABASE, $USER_DATABASE, $PASS_DATABASE, $DATABASE_NAME);
} catch (Exception $e) {
    throw new ErrorException("Error connecting to MySQL, check credentials - ",  $e->getMessage());
}
?>