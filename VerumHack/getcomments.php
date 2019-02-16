<?php 
        $con = new mysqli('localhost', 'u761899477_wang', 'Lightpower1', 'u761899477_verum');
        $id = $_POST['id'];
        $sql = $con->query("SELECT * FROM comments WHERE post_id = $id ");
        if($sql->num_rows > 0){
            if($json = mysqli_fetch_all ($sql, MYSQLI_ASSOC)){
                
            }
        }
         echo json_encode($json);


?>