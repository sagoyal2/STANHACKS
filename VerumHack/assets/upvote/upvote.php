<?php
    session_start();
    $conn = mysqli_connect('localhost', 'u761899477_wang', 'Lightpower1', 'u761899477_verum');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
        $id = $_POST['pid'];
        $ttype = $_POST['ptype'];
        $votes = $_POST['pnum'];
        $sql = $conn->prepare("SELECT * FROM votes WHERE post_id = ? AND user_id = ?");
        $sql->bind_param("ii", $id, $_SESSION['user']);
        $sql->execute();
        $valid = $sql->get_result();
        $result = $valid->fetch_assoc();
        if($valid->num_rows < 1 && isset($_SESSION['user'])){
            $pdoc = $conn->prepare("INSERT INTO votes (post_id, user_id, vote_type, total_votes) VALUE (?,?,?,?)");
            $pdoc->bind_param("iiii", $id, $_SESSION['user'], $ttype, $votes);
            $pdoc->execute();
            $stmt = $conn->prepare("UPDATE posts SET votes=? WHERE id=?");
            if ($stmt === false) {
            trigger_error($this->mysqli->error, E_USER_ERROR);
             return;
            }
            $stmt->bind_param("ii", $votes, $id);
            $stmt->execute();
            $stmt->close();
         } else if($result['vote_type'] != $ttype && isset($_SESSION['user'])){
            $pdor = $conn->prepare("UPDATE votes SET vote_type=?, total_votes=? WHERE post_id=? AND user_id=?");
            $pdor->bind_param("iiii", $ttype , $votes, $id, $_SESSION['user']);
            $pdor->execute();
            $stmt = $conn->prepare("UPDATE posts SET votes=? WHERE id=?");
            if ($stmt === false) {
            trigger_error($this->mysqli->error, E_USER_ERROR);
             return;
            }
            $stmt->bind_param("ii", $votes, $id);
            $stmt->execute();
            $stmt->close();
        } else if(isset($_SESSION['user'])){
            $tremp = 0;
            $pdof = $conn->prepare("UPDATE votes SET vote_type=?, total_votes=? WHERE post_id=? AND user_id=?");
            $pdof->bind_param("iiii", $tremp , $votes, $id, $_SESSION['user']);
            $pdof->execute();
            $stmt = $conn->prepare("UPDATE posts SET votes=? WHERE id=?");
            if ($stmt === false) {
            trigger_error($this->mysqli->error, E_USER_ERROR);
             return;
            }
            $stmt->bind_param("ii", $votes, $id);
            $stmt->execute();
            $stmt->close();

        } 
    ?>