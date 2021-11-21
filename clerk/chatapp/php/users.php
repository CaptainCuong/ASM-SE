<?php
    session_start();
    include_once "config.php";
    $outgoing_id = $_SESSION['username_restaurant_qRewacvAqzA'];
    $sql = "SELECT * FROM users WHERE NOT username = '{$outgoing_id}' ORDER BY username DESC";
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No users are available to chat";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }
    echo $output;
?>
