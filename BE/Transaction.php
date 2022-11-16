<?php
    include "config/auth.php";

    $response = array();

    $action = '';

    if(isset($_GET['action'])) {
       $action = $_GET['action']; 
    }

    if($action="read") { 
        if($_GET["page"]) {
            $page = $_GET["page"];
            $row_per_page = 10;
    
            $begin = ($page * $row_per_page) - $row_per_page;
    
            $sql = "SELECT * FROM transaction LIMIT {$begin}, {$row_per_page}";
            $table_data = $conn->query($sql);
    
            $data = array();
            while($row = $table_data->mysqli_fetch_array($table_data, MYSQLI_ASSOC)) {
                $data[] = $row;
            }
    
            if(count($data) > 0 ) {
                $response["DATA"] = $data;
                $response["MESSAGE"] = "DATA FOUND";
                $response["STATUS"] = 200;
            } else {
                $response["MESSAGE"] = "DATA NOT FOUND";
                $response["STATUS"] = 404;
            }
        }
        else {
            $response["MESSAGE"] = "INVALID REQUEST";
            $response["STATUS"] = 400;
        }
    }

    if($action="search") {

        $name = $_POST["name"];
        $sql1 = "SELECT * FROM merchant WHERE merchant_name = '$name'";
        $data_merchant = $conn->query($sql1);

        $row = $table_data->mysqli_fetch_array($data_merchant, MYSQLI_ASSOC);
        
        $merchant_id = $row->merchant_id;
        if($_GET["page"]) {
            $page = $_GET["page"];
            $row_per_page = 10;
    
            $begin = ($page * $row_per_page) - $row_per_page;
    
            $sql = "SELECT * FROM transaction WHERE Merchant_id = '$merchant_id' LIMIT {$begin}, {$row_per_page}";
            $table_data = $conn->query($sql);
    
            $data = array();
            while($row = $table_data->mysqli_fetch_array($table_data, MYSQLI_ASSOC)) {
                $data[] = $row;
            }
    
            if(count($data) > 0 ) {
                $response["DATA"] = $data;
                $response["MESSAGE"] = "DATA FOUND";
                $response["STATUS"] = 200;
            } else {
                $response["MESSAGE"] = "DATA NOT FOUND";
                $response["STATUS"] = 404;
            }
        }
        else {
            $response["MESSAGE"] = "INVALID REQUEST";
            $response["STATUS"] = 400;
        }
    }
    

    echo json_encode($response);
?>