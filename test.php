<?php
$password = "admin123";
$tt = password_hash($password,PASSWORD_DEFAULT);
echo $tt;
