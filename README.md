# Exam in Tīmekļa vietņu programmēšana (WEB) 2024

## For it to work you need config.php file that should sit in admin/database folder for database access
### database/config.php
```php
<?php
$server = "localhost"; 
$username = "{your username to phpmyadmin}"; 
$password = "{your password to phpmyadmin}"; 
$db = "{your db in phpmyadmin}"; 


    $con = mysqli_connect($server, $username, $password, $db)
?>
```

![relations](https://github.com/user-attachments/assets/41e86fb9-1de5-46c2-b55c-848698aa326e)
