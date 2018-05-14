<?php
include_once("../classes/Like.class.php");
session_start();
$userid = $_SESSION['userid'];
$likecount = Like::Checklike(strip_tags($_POST['postid'], $userid));

if ($likecount > 0){
    Like::Removelike(strip_tags($_POST['postid'], $userid));
    $feedback['status'] = 'unsuccess';
}
else{
$like = new Like();
$like->Addlike(strip_tags($_POST['postid'], $userid));
    $feedback['status'] = 'success';
}


header('Content-Type: application/json');
echo json_encode($feedback);
?>