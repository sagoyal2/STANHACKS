<?php 
            session_start();
         $conn = new mysqli('localhost', 'u761899477_wang', 'Lightpower1', 'u761899477_verum');
         $start = $_POST['start'];
         $id = $_SESSION['user'];
         $sql = $conn->query("SELECT * FROM posts ORDER BY votes");
         if($sql->num_rows > $start){
             $stmt = $conn->query("SELECT * FROM posts ORDER BY votes DESC LIMIT $start, 6");
             if($json = mysqli_fetch_all ($stmt, MYSQLI_ASSOC)){
                     foreach (array_keys($json) as $key) {
                            $cid = $json[$key]['id'];
                            $sqt = $conn->query("SELECT * FROM votes WHERE post_id = $cid");
                            $result = $sqt->fetch_assoc();
                            $json[$key]['votetype'] = $result['vote_type'];
                        }
    
                }
            }else{
                $json = array('max' => true);
    
            }
             echo json_encode($json);
?>