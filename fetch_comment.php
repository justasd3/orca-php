<?php

//fetch_comment.php

$connect = new PDO('mysql:host=sql210.epizy.com;dbname=epiz_29199337_orcaphpdatabase', 'epiz_29199337', 'd5F7f2VdQTB8Mm');

$query = "
SELECT * FROM comments
WHERE father_id = '0' 
ORDER BY id DESC
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
$output = '';
foreach ($result as $row) {
    $post_id = $row["id"];
    $output .= '
 <div class="container mt-5">
 <div class="card bg-light">
     <div class="row">
         <div class="col-11 d-flex pt-3">
             <h4 class="fw-bold">' . $row["name"] . ' &nbsp; <h5 class="fw-normal"> ' . $row["created_at"] . ' </h5>
         </div>
         <div class="col-1 pt-3">
             <h5>' . $row["id"] . '</h5>
             <button onclick="showform(' . $row['id'] . ')">button</button>
             </form>
             </div>
     </div>
         <div class="row">
             <div>
                 <h5 class="fw-normal"> ' . $row["comment"] . ' </h5>
         </div>
     </div>

 </div>

 <div id="form-' . $row['id'] . '" class="container mt-5" style="display: none;">
        <form id="input_form-' . $row['id'] . '" method="POST">
            <div class="row">
                <div class="col-2">
                    <h4 class="fw-bold">Email*</h4>
                </div>
                <div class="col-4">
                    <input type="text" id="email" name="email" class="form-control form-control-sm mb-2">
                </div>
                <div class="col-2">
                    <h4 class="fw-bold">Name*</h4>
                </div>
                <div class="col-4">
                    <input type="text" id="name" name="name" class="form-control form-control-sm mb-2">
                </div>
            </div>
            <div class="row pt-5">
                <div class="col-2">
                    <h4 class="fw-bold">Comment*</h4>
                </div>
                <div class="col-9">
                    <input type="text" id="comment_data" name="comment_data" class="form-control form-control-lg mb-3" style="height:100px; width:1075px">
                </div>
            </div>
            <div class="row pt-5">
                <div class="col-2">
                </div>
                <div class="col-2">
                <input type="hidden" name="id" id="id" value="' . $row['id'] . '" />
                    <input type="submit" name="submit" id="submit" class="btn btn-secondary" value="Submit" onclick="insertfunc(' . $row['id'] . ')"/>
                </div>
            </div>
        </form>
        <span id="comment_message"></span>
        <br />
        <div id="display_comment"></div>
    </div>
 </p>

</div>';
    $output .= get_reply_comment($connect, $row["id"]);
}

echo $output;

function get_reply_comment($connect, $father_id = 0, $marginleft = 0)
{
    $query = "SELECT * FROM comments WHERE father_id = '" . $father_id . "' ";
    $output = '';
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $count = $statement->rowCount();
    if ($father_id == 0) {
        $marginleft = 0;
    } else {
        $marginleft = $marginleft + 48;
    }
    if ($count > 0) {
        foreach ($result as $row) {
            $output .= '
             <div class="container mt-3">
    <div class="row">
        <div class="col-2"> </div>
           <div class="col-10">
                <div class="card bg-light">
                     <div class="col-11 d-flex pt-3">
                        <h4 class="fw-bold">' . $row["name"] . ' &nbsp; <h5 class="fw-normal"> ' . $row["created_at"] . ' </h5>
                     </div>
                    <h5 class="fw-normal"> ' . $row["comment"] . ' </h5>
                </div>
                <div>
            </div>
        </div>
    </div>  
 ';
            $output .= get_reply_comment($connect, $row["id"], $marginleft);
        }
    }
    return $output;
}
?>