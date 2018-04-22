<?php
include_once('classes/Post.class.php');
include_once('classes/User.class.php');
include_once("includes/functions.inc.php");
checklogin();
$post = Post::ShowPosts();

if(! empty($_POST)) {

    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileActualExt, $allowed)){
        if ($fileError === 0){
            if ($fileSize < 10000){
                $fileNameNew = uniqid('', true).".".$fileActualExt;
                $fileDestination = 'uploads/'.$fileNameNew;
                print_r($fileDestination);
                move_uploaded_file($fileTmpName, $fileDestination);

                $title = $_POST['title'];
                $desc = $_POST['description'];
                $date = date("Y-m-d");
                $location = "";
                $userid = $_SESSION['userid'];
                $newPost = new Post();

                $newPost->setTitle($title);
                $newPost->setPicture($fileDestination);
                $newPost->setDescription($desc);
                $newPost->setDate($date);
                $newPost->setUserId($userid);
                $newPost->setLocation($location);
                if ($newPost->AddPost() ){
                    $feedback = "Post has been saved.";
                }

            } else{
                $feedback = "Your file is too big.";
            }
        } else{
            $feedback = "There was an error uploading your file.";
        }
    } else{
        $feedback = "You cannot upload files of this type.";
    }



}
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add post - Snapshot</title>
    <meta name="description" content="snapshot" />
    <meta name="keywords" content="snapshot, imd" />
    <meta name="author" content="Lucas Debelder, Sander Verbesselt, Frederik Delaet" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:600,800|Open+Sans" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.0.4/js/all.js"></script>
    <link rel="stylesheet" type="text/css" href="css/reset.css" />
    <link rel="stylesheet" type="text/css" href="css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="css/master.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />

    <meta property="og:url" content="">
    <meta property="og:type" content=""/>
    <meta property="og:title" content=""/>
    <meta property="og:description" content=""/>
    <meta property="og:image" content=""/>


    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="">
    <meta name="twitter:creator" content="">
    <meta name="twitter:title" content="">
    <meta name="twitter:description" content=" ">
    <meta name="twitter:image" content="">

</head>

<body>
<nav>
    <ul>
        <li><img src="media/frontend/logo.svg" alt="Logo" ></li>

        <li><a href="index.php">Home</a></li>
        <li><a href="posts.php">Posts</a></li>
        <li><a class="active" href="addpost.php">Add post</a></li>
        <li><a href="account.php">Profile settings</a></li>
        <li><a href="logout.php">Log out</a></li>
    </ul>
</nav>

<form  action="" method="post" enctype="multipart/form-data">

            <h1 form__title>Add post</h1>
            <div class="form__field">
                <label for="title" class="label">YOUR SHOT TITLE:</label> <br/>
                <input type="text" name="title">
            </div>
            <div class="form__field">
                <label for="file" class="label">UPLOAD PICTURE</label><br/>
                <input type="file" name="file" class="fileToUpload">
            </div>
            <div class="form__field">
                <label for="description" class="label">DESCRIPTION</label><br/>
                <textarea name="description" cols="25" rows="5"></textarea>
            </div>

            <div class="form__field">
                <label for="tag" class="label">ADD SOME TAGS TO YOUR SHOT (seperated with , )</label><br/>
                <input type="text" name="tag">
            </div>

            <p>JPG, GIF or PNG. Snapshots are 400 × 300 pixels or 800 × 600 (for HiDPI displays). </p>

            <div class="form__field">
                <input class="btn_login" type="submit" name="submit" value="Add post"">
            </div>

        </form>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>

</script>
</html>

