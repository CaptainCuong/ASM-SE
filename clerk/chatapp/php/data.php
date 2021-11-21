<?php
    while($row = mysqli_fetch_assoc($query)){
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = '{$row['username']}'
                OR outgoing_msg_id = '{$row['username']}') AND (outgoing_msg_id = '{$outgoing_id}' 
                OR incoming_msg_id = '{$outgoing_id}') ORDER BY msg_id DESC LIMIT 1";
        $query2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($query2);

        // Khong co tin nhan
        (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result ="No message available";
        
        // Cat ngan tin nhan
        (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
        
        // Tin nhan cua minh thi co chu you. VD: "You: abcd"
        if(isset($row2['outgoing_msg_id'])){
            ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
        }else{
            $you = "";
        }

        // Status
        // ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";

        // Khong the hien chinh minh, ko can thiet do query khong co minh
        // ($outgoing_id == $row['username']) ? $hid_me = "hide" : $hid_me = "";

        $output .= '<a href="chatapp/chat.php?user_id='. $row['username'] .'">
                    <div class="content">
                    <div class="details">
                        <span>' . $row['full_name'] . '</span>
                        <p>'. $you . $msg .'</p>
                    </div>
                    </div>
                    <div class="status-dot online">
                        <i class="fa fa-commenting"></i>
                        <span>' . $row['role'] . '</span>
                    </div>
                </a>';
    }
?>