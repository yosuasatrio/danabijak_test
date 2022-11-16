<?php
    include "config/auth.php";
    //echo ("Success");

    $result = array('error' => false);
    $action = '';

    if(isset($_GET['action'])) {
       $action = $_GET['action']; 
    }

    if($action == 'read') {
        $sql = $conn->query("SELECT * FROM account");
        $account = array();
        while($row = $sql->fetch_assoc()) {
            array_push($account, $row);
        }
        $result['account'] = $account;
    }

    if($action == 'create') {
        $name = $_POST['name'];
        $number = $_POST['number'];
        $balance = $_POST['balance'];

        $sql = $conn->query("INSERT INTO account (name, number,balance ) VALUES ('$name', '$number', '$balance')");
        if($sql) {
            $result['message'] = "Account added successfully!";
        } else {
            $result['error'] = true;
            $result['message'] = "Failed to add account";
        }
    }

    if($action == 'update') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $number = $_POST['number'];
        $balance = $_POST['balance'];

        $sql = $conn->query("UPDATE account SET name = '$name', number='$number', balance='$balance' WHERE id='$id'");
        if($sql) {
            $result['message'] = "Account updated Successfully!";
        } else {
            $result['error'] = true;
            $result['message'] = "Failed to update account";
        }
    }

    if($action == 'delete') {
        $id = $_POST['id'];
        

        $sql = $conn->query("DELETE FROM account WHERE id='$id'");
        if($sql) {
            $result['message'] = "Account delete Successfully!";
        } else {
            $result['error'] = true;
            $result['message'] = "Failed to delete account";
        }
    }

    $conn->close();
    echo json_encode($result);
?>