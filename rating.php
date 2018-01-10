<?
require('connection.php');
require('tools.php');
require('msg.php');


if(isset($_POST['action'])){
    $action = $_POST['action'];
    switch($action){
        case 'like':
            $sql = "INSERT INTO like (id_element,u_id,score) VALUES ($_POST['element'], $_POST['user'], 1 )";
        break;
            
        case 'dislike':
            $sql = "INSERT INTO like (id_element,u_id,score) VALUES ($_POST['element'], $_POST['user'], -1)";
        break;
            
        case 'unlike':
            $sql = "DELETE FROM like WHERE u_id = $_POST['user'] AND id_element = $_POST['element']";
            break;
        case 'undislike':
            $sql = "DELETE FROM like WHERE u_id = $_POST['user'] AND id_element = $_POST['element']";
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
    $sql = "SELEC COUNT(*) FROM like WHERE id_element = %id AND score = 1";
    $rs = select($sql);
    $result = mysqli_fetch_array($rs);
    return $result[0];
}

//Total dislikes
function getDislikes($id){
    $sql = "SELEC COUNT(*) FROM like WHERE id_element = %id AND score = -1";
    $rs = select($sql);
    $result = mysqli_fetch_array($rs);
    return $result[0];
}


//Total of like and dislikes
function getRating($id){
    $rating = array();
    $like_query = "SELEC COUNT(*) FROM like WHERE id_element = %id AND score = 1";
    $dislike_query = "SELEC COUNT(*) FROM like WHERE id_element = %id AND score = -1";
    $likes_res = select($like_query);
    $dislike_res = select($dislike_query);
    $likes = mysqli_fetch_array($likes_res);
    $dislike = mysqli_fetch_array($dislikes_res);
    
    rating = [
        'likes' => $likes[0],
        'dislikes' => $dislikes[0]
    ];
    return json_encode($rating);
}

function userLiked($id_element){
    global $user_id;
    $sql = "SELECT * FROM like WHERE u_id = $user_id AND id_element = $id_element AND score = 1 ";
    $result = select($sql);
    if(mysql_num_rows($result)>0){
        return true;
    }else{
        return false;
    }
}

function userDisliked($id_element){
    global $user_id;
    $sql = "SELECT * FROM like WHERE u_id = $user_id AND id_element = $id_element AND score = -1 ";
    $result = select($sql);
    if(mysql_num_rows($result)>0){
        return true;
    }else{
        return false;
    }
}

