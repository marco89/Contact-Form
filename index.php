<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <title>Contact Form</title>
</head>

<body>

    <?php


    // creates assoc arr
    $issue_type = array(
        "feedback" => "Feedback",
        "query" => "Query",
        "complaint" => "Complaint",
        "other" => "Other",
    );

    ?>
    <div class="container-fluid w-100 h-100 p-3 bg-info">
        <div class="container-fluid w-50 h-75 p-2 bg-info mt-2 rounded text-white">
            <div class="col-md-12 text-center">
                <h1>Contact Form</h1>
            </div>
            <form action="result.php" method="POST" enctype="multipart/form-data">
                <div>
                    <input type="text" id="user-name " name="user-name" value="<?= $_POST['user-name'] ?? ''; ?>" placeholder="Enter your name" />
                    <br>
                    <input type="text" id="user-email" name="user-email" value="<?= $_POST['user-email'] ?? ''; ?>" placeholder="Enter your email">
                    <br>

                    <div class="col-md-5 pl-0">
                        <select name="dropdown" id="dropdown">
                            <option value="" hidden>Select issue</option>
                            <?php
                            foreach ($issue_type as $id => $display) {
                                echo '<option ' . (($_POST['dropdown'] == $id) ? "selected" : "") . ' value="' . $id . '" >' . $display . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <br>

                    <textarea id="notes" name="notes" value="<?= $_POST['notes'] ?? ''; ?>" placeholder="Please provide a short explanation of your query"></textarea>

                    <div style="width:320px; max-width:320px;">
                        <script>
                            $(document).ready(function() {
                                $('#notes').summernote({
                                    maxWidth: 160
                                });
                            });
                        </script>
                    </div>

                    <div class="col-md-15 text-right">
                        <button class="btn btn-success" id="submit-form">Submit Form</button>
                    </div>

                    <style>
                        .note-editable {
                            background-color: white !important;
                            color: black !important;
                        }
                    </style>

                </div>
        </div>
    </div>
    </form>
</body>

</html>