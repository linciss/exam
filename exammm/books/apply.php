<?php 
require '../admin/database/config.php';
session_start();

if(isset($_POST['bookId'])){
    $name = htmlspecialchars($_POST['name']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $bookId = intval($_POST['bookId']);

    $query = $con->prepare("SELECT reader_id FROM ex_readers WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $query->store_result();

    if ($query->num_rows > 0) {
        $updateQuery = $con->prepare("UPDATE ex_readers SET name = ?, last_name = ?, phone = ?, book_id = ?, status='waiting', date_taken = NULL, date_returned = NULL, reg_date = NOW()  WHERE email = ?");
        $updateQuery->bind_param("sssis", $name, $lastName, $phone, $bookId, $email);
        if ($updateQuery->execute()) {
            $_SESSION['success'] = 'Pieteikums pievienots!';
            $_SESSION['successMessage'] = '
                <p class="text-md">Dodieties uz mūsu bibliotēku Ventspils ielā 51. Jums ir 7 dienu laiks, lai grāmatu savāktu!</p>
            ';
        } else {
            $_SESSION['error'] = 'Kļūda!';
        }
        $updateQuery->close();
    } else {
        $insertQuery = $con->prepare("INSERT INTO ex_readers (name, last_name, phone, email, book_id) VALUES (?, ?, ?, ?, ?)");
        $insertQuery->bind_param("ssssi", $name, $lastName, $phone, $email, $bookId);
        if ($insertQuery->execute()) {
            $_SESSION['success'] = 'Pieteikums pievienots!';
            $_SESSION['successMessage'] = '
                <p class="text-md">Dodieties uz mūsu bibliotēku Ventspils ielā 51. Jums ir 7 dienu laiks, lai grāmatu savāktu!</p>
            ';
        } else {
            $_SESSION['error'] = 'Kļūda!';
        }
        $insertQuery->close();
    }

   
    $con->close();
}