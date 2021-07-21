<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<header>
    <div class="border-top border-secondary border-4 my-1"></div>
    <h1 class="header" style="text-align:center;color:grey;"> Comment form </h1>
    <div class="border-top border-secondary border-4 my-1"></div>

</header>

<body>
    <div class="container mt-5">
        <form id="input_form" method="POST">
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
                <input type="hidden" name="id" id="id" value="0" />
                    <input type="submit" name="submit" id="submit" class="btn btn-secondary" value="Submit" />
                </div>
            </div>
        </form>
        <span id="comment_message"></span>
        <br />
        <div id="display_comment"></div>
    </div>
</body>
</html>

<script>
    $(document).ready(function() {
        $('#input_form').on('submit', function(event) {
            event.preventDefault();

            var form_data = $(this).serialize();
            alert(form_data);
            $.ajax({
                url: "insert_comment.php",
                method: "POST",
                data: form_data,
                dataType: "JSON",
                success: function(data) {
                    if (data.error != '') {
                        $('#input_form')[0].reset();
                        $('#comment_message').html(data.error);
                        $('#id').val('0');
                        load_comment();
                    }
                }
            })
        });
        load_comment();

        $(document).on('click', '.reply', function() {
            var id = $(this).attr("id");
            $('#id').val(id);
            $('#comment_name').focus();
        });

    });
    function load_comment() {
            $.ajax({
                url: "fetch_comment.php",
                method: "POST",
                success: function(data) {
                    $('#display_comment').html(data);
                }
            })
        }

    function showform(id) {
        var x = document.getElementById("form-" + id);
        if (x.style.display == "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }


    function insertfunc(id) {
        event.preventDefault();
        var form_data = $('#input_form-' + id).serialize();
        // var form_data = $(this).serialize();

        $.ajax({
            url: "insert_comment.php",
            method: "POST",
            data: form_data,
            dataType: "JSON",
            success: function(data) {
                if (data.error != '') {
                    $('#input_form')[0].reset();
                    $('#comment_message').html(data.error);
                    $('#id').val('0');
                }
            }
        })
        load_comment();

    }
</script>