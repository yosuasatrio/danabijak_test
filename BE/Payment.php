<?php
    include "config/auth.php";
    //echo ("Success");

    $result = array('error' => false);
    $action = '';

    if(isset($_GET['action'])) {
       $action = $_GET['action']; 
    }

    if($action == 'read') {
        $sql = $conn->query("SELECT * FROM payment");
        $payment = array();
        while($row = $sql->fetch_assoc()) {
            array_push($payment, $row);
        }
        $result['payment'] = $payment;
    }

    if($action == 'create') {
        $description = $_POST['description'];
        $amount = $_POST['amount'];
        $type_key = $_POST['type_key'];
        $remitter_account_id = $_POST['remitter_account_id'];
        $beneficiary_account_id = $_POST['beneficiary_account_id'];

        $sql = $conn->query("INSERT INTO payment (description, amount, type_key,remitter_account_id , beneficiary_account_id ) 
        VALUES ('$description', '$amount', '$type_key' , '$remitter_account_id', '$beneficiary_account_id')");
        if($sql) {
            $result['message'] = "payment added successfully!";
        } else {
            $result['error'] = true;
            $result['message'] = "Failed to add payment";
        }
    }

    if($action == 'update') {
        $id = $_POST['id'];
        $description = $_POST['description'];
        $amount = $_POST['amount'];
        $type_key = $_POST['type_key'];
        $remitter_account_id = $_POST['remitter_account_id'];
        $beneficiary_account_id = $_POST['beneficiary_account_id'];

        $sql = $conn->query("UPDATE payment SET description = '$description', amount='$amount', type_key='$type_key' , remitter_account_id='$remitter_account_id', beneficiary_account_id='$beneficiary_account_id' WHERE id='$id'");
        if($sql) {
            $result['message'] = "payment updated Successfully!";
        } else {
            $result['error'] = true;
            $result['message'] = "Failed to update payment";
        }
    }

    if($action == 'delete') {
        $id = $_POST['id'];
        

        $sql = $conn->query("DELETE FROM payment WHERE id='$id'");
        if($sql) {
            $result['message'] = "payment delete Successfully!";
        } else {
            $result['error'] = true;
            $result['message'] = "Failed to delete payment";
        }
    }

    $conn->close();
    echo json_encode($result);
?>