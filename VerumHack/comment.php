<?php
    $con = new mysqli('localhost', 'u761899477_wang', 'Lightpower1', 'u761899477_verum');

    $comment = $con->prepare("INSERT INTO comments (post_id, Name, comment) VALUES (?,?,?)");
    $comment->bind_param("iss", $_POST['id'], $_POST['name'], $_POST['message']);
    $comment->execute();
    $con->close();

?>