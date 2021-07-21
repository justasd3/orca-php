<?php

$connect = new PDO('mysql:host=sql210.epizy.com;dbname=epiz_29199337_orcaphpdatabase', 'epiz_29199337', 'd5F7f2VdQTB8Mm');

$error = '';
$name = '';
$comment_data = '';
$email = '';


if(empty($_POST["name"]))
{
 $error .= '<p class="text-danger">Name is required</p>';
}
else
{
 $name = $_POST["name"];
}

if(empty($_POST["comment_data"]))
{
 $error .= '<p class="text-danger">Comment is required</p>';
}
else
{
 $comment_data = $_POST["comment_data"];
}

if(empty($_POST["email"]))
{
 $error .= '<p class="text-danger">email is required</p>';
}
else
{
 $email = $_POST["email"];
}

if($error == '')
{
 $query = "
 INSERT INTO comments
 (father_id, name, comment, email) 
 VALUES (:father_id, :name, :comment, :email)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':father_id' => $_POST["id"],
   ':comment'    => $comment_data,
   ':name' => $name,
   ':email' => $email,
  )
 );
 $error = '<label class="text-success">Comment Added</label>';
}

$data = array(
 'error'  => $error
);

echo json_encode($data);

?>
