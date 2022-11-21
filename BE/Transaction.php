<?php
    include "config/auth.php";

    $response = array();

    $action = '';

    if(isset($_GET['action'])) {
       $action = $_GET['action']; 
    }

    if($action=="read") { 
        if($_GET["page"]) {

        if (isset($_GET['page']) && $_GET['page']!="") {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

        $total_records_per_page = 10;

        $offset = ($page-1) * $total_records_per_page;
        $previous_page = $page - 1;
        $next_page = $page + 1;
        $adjacents = "2";

        $result_count_1 = "SELECT COUNT(*) As total_records FROM `transaction`";
        $result_count = $conn->query($result_count_1);
        $total_records = mysqli_fetch_array($result_count);
        $total_records = $total_records['total_records'];
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1; // total pages minus 1
        //echo "offset : ".$offset."";

        //$begin = ($page * $row_per_page) - $row_per_page;

        //$sql = "SELECT * FROM transaction WHERE Merchant_id = '$merchant_id' LIMIT {$begin}, {$row_per_page}";
        $sql = "SELECT * FROM `transaction` LIMIT $offset, $total_records_per_page";
        $table_data = $conn->query($sql);

        $data = array();
        while($row = $table_data->fetch_assoc()) {
            $data[] = $row;
        }

        if(count($data) > 0 ) {
            $response["PAGE"] = $page;
            $response["TOTAL_DATA"] = $total_records;
            $response["LIMIT"] = $total_records_per_page;
            $response["DATA"] = $data;
            $response["MESSAGE"] = "DATA FOUND";
            $response["STATUS"] = 200;
        } else {
            $response["PAGE"] = $page;
            $response["TOTAL_DATA"] = $total_records;
            $response["LIMIT"] = $total_records_per_page;
            $response["MESSAGE"] = "DATA NOT FOUND";
            $response["STATUS"] = 404;
        }
    }
    else {
        $response["MESSAGE"] = "INVALID REQUEST";
        $response["STATUS"] = 400;
    }
    echo json_encode($response);
    }

    if($action=="search") {

            $name = $_POST["name"];
            $sql1 = "SELECT Merchant_ID FROM merchant WHERE Merchant_name = '".$name."'";
            $result2 = mysqli_query($conn, $sql1);
            $row2   = mysqli_fetch_row($result2);

            $merchant_id = $row2[0];
            
            if($_GET["page"]) {

            if (isset($_GET['page']) && $_GET['page']!="") {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }

            $total_records_per_page = 10;

            $offset = ($page-1) * $total_records_per_page;
            $previous_page = $page - 1;
            $next_page = $page + 1;
            $adjacents = "2";

            $result_count_1 = "SELECT COUNT(*) As total_records FROM `transaction` WHERE Merchant_id = '".$merchant_id."'";
            $result_count = $conn->query($result_count_1);
            $total_records = mysqli_fetch_array($result_count);
            $total_records = $total_records['total_records'];
            $total_no_of_pages = ceil($total_records / $total_records_per_page);
            $second_last = $total_no_of_pages - 1; // total pages minus 1
            //echo "offset : ".$offset."";
    
            //$begin = ($page * $row_per_page) - $row_per_page;
    
            //$sql = "SELECT * FROM transaction WHERE Merchant_id = '$merchant_id' LIMIT {$begin}, {$row_per_page}";
            $sql = "SELECT * FROM `transaction` WHERE Merchant_id = '".$merchant_id."' LIMIT $offset, $total_records_per_page";
            $table_data = $conn->query($sql);
    
            $data = array();
            while($row = $table_data->fetch_assoc()) {
                $data[] = $row;
            }
    
            if(count($data) > 0 ) {
                $response["PAGE"] = $page;
                $response["TOTAL_DATA"] = $total_records;
                $response["LIMIT"] = $total_records_per_page;
                $response["DATA"] = $data;
                $response["MESSAGE"] = "DATA FOUND";
                $response["STATUS"] = 200;
            } else {
                $response["PAGE"] = $page;
                $response["TOTAL_DATA"] = $total_records;
                $response["LIMIT"] = $total_records_per_page;
                $response["MESSAGE"] = "DATA NOT FOUND";
                $response["STATUS"] = 404;
            }
        }
        else {
            $response["MESSAGE"] = "INVALID REQUEST";
            $response["STATUS"] = 400;
        }
        echo json_encode($response);
    }    
?>