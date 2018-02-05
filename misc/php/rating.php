<?php
require('connection.php');
require('tools.php');
require('msg.php');
require('checkSession.php');

if(isset($_POST['action'])){
    $action = $_POST['action'];
    switch($action){
        case 'Like':
            $sql = "INSERT INTO likes (id_song,u_id,score) VALUES ({$_POST['element']}, {$_SESSION['userID']}, '1' )";
        break;
            
        case 'Dislike':
            $sql = "INSERT INTO likes (id_song,u_id,score) VALUES ({$_POST['element']}, {$_SESSION['userID']}, -1)";
        break;
            
        case 'Unlike':
            $sql = "DELETE FROM likes WHERE u_id = {$_SESSION['userID']} AND id_song = {$_POST['element']}";
            break;
        case 'Undislike':
            $sql = "DELETE FROM likes WHERE u_id = {$_SESSION['userID']} AND id_song = {$_POST['element']}";
            break;
            
        default :
            break;
    }
    
    //execute query
    if(isset($sql))
        insert($sql);
    exit(0);
}

//Total numbers of likes
function getLikes($id){
    $sql = "SELEC COUNT(*) FROM likes WHERE id_song = %id AND score = 1";
    $rs = select($sql);
    $result = mysqli_fetch_array($rs);
    return $result[0];
}

//Total dislikes
function getDislikes($id){
    $sql = "SELEC COUNT(*) FROM likes WHERE id_song = %id AND score = -1";
    $rs = select($sql);
    $result = mysqli_fetch_array($rs);
    return $result[0];
}


//Total of like and dislikes
function getRating($id){
    $rating = array();
    $like_query ="SELECT COUNT(*) FROM likes WHERE id_song = %id AND score = 1";
    $dislike_query = "SELECT COUNT(*) FROM likes WHERE id_song = %id AND score = -1";
    $likes_res = select($like_query);
    $dislike_res = select($dislike_query);
    $likes = mysqli_fetch_array($likes_res);
    $dislike = mysqli_fetch_array($dislikes_res);
    
    $rating = [
        'likes' => $likes[0],
        'dislikes' => $dislikes[0]
    ];
    return json_encode($rating);
}

function userLiked($id_element){
    global $user_id;
    $sql = "SELECT * FROM likes WHERE u_id = '$user_id' AND id_song = '$id_element' AND score = 1 ";
    $result = select($sql);
    if(mysql_num_rows($result)>0){
        return true;
    }else{
        return false;
    }
}

function userDisliked($id_element){
    global $user_id;
    $sql = "SELECT * FROM likes WHERE u_id = $user_id AND id_song = $id_element AND score = -1 ";
    $result = select($sql);
    if(mysql_num_rows($result)>0){
        return true;
    }else{
        return false;
    }
}

