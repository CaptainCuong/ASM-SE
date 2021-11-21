<?php
    session_start();
    include_once "config.php";
    $outgoing_id = $_SESSION['table_id'];
    $sql = "SELECT * FROM tables WHERE NOT table_id = {$outgoing_id} ORDER BY table_id DESC";
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No users are available to chat";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }
    echo $output;
?>