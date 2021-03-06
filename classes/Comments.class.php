<?php

include_once("Db.class.php");
include_once("Post.class.php");
include_once("User.class.php");

class Comments extends Post{

    private $Comment;



    public function getComment()
    {
        return strip_tags($this->Comment);
    }

    public function setComment($Comment)
    {
        $this->Comment = $Comment;
    }

    public function AddComment($postid){

        $conn = db::getInstance();
        $query = "insert into comments (post_id, comment, user_id, post_date) values (:post_id, :comment, :user_id, :post_date)";
        $statement = $conn->prepare($query);
        $statement->bindValue(':post_id',$postid);
        $statement->bindValue(':comment',$this->getComment());
        $statement->bindValue(':user_id',$this->getUserId());
        $statement->bindValue(':post_date',$this->getDate());
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function ShowComments($p_id){

        $conn = db::getInstance();
        $query = "SELECT comments.id, comments.comment, comments.post_date, comments.user_id, users.username 
                  FROM comments 
                  INNER JOIN users 
                  ON comments.user_id=users.id
                  WHERE post_id = $p_id ORDER BY post_date DESC;";
        $statement = $conn->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}