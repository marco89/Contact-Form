<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Your contact data</title>
</head>

<body>
    <?php

    $pdo = require_once 'db.php';


    $issue_type = array(
        "feedback" => "Feedback",
        "query" => "Query",
        "complaint" => "Complaint",
        "other" => "Other",
    );

    ?>

    <form action="index.php" method="POST" enctype="multipart/form-data" class="container">
        <div class="bg-info">
            <div class="row bg-info p-5">

                <?php

                try {
                    $data_source = "mysql:host=$server;dbname=$database;charset=$charset";
                    $pdo = new PDO($data_source, $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    echo "connection successful";
                    //return $pdo;

                    if (empty($_POST['user-name']) || is_numeric($_POST['user-name'])) {
                        throw new \Exception('Please enter a valid name.');
                    }
                    if (empty($_POST['user-email']) || (!filter_var($_POST['user-email'], FILTER_VALIDATE_EMAIL))) {
                        throw new \Exception('Please enter a valid email.');
                    }
                    if (empty($_POST['dropdown'])) {
                        throw new \Exception('No issue type selected');
                    }
                    if (empty($_POST['text-box'])) {
                        throw new \Exception('Please provide a short description of the reason for your email.');
                    }

                    $name = htmlspecialchars($_POST['user-name']);
                    $email = htmlspecialchars($_POST['user-email']);
                    $issue = htmlspecialchars($_POST['dropdown']);
                    $notes = htmlspecialchars(strip_tags($_POST['text-box']));

                ?>

                    <div class="col-md-3">
                        <label>
                            Name
                        </label>
                        <input class="form-control" type="text" name="user-name" value="<?= $name ?>">
                    </div>
                    <div class="col-md-3">
                        <label>
                            E-mail
                        </label>
                        <input class="form-control" type="text" name="user-email" value="<?= $email ?>">
                    </div>
                    <div class="col-md-3 pt-5">
                        <label>
                            Issue type
                        </label>
                        <select name="dropdown" id="dropdown">
                            <option value="" hidden>Select issue</option>
                            <?php
                            // cycles through all arr elements and checks whether $_POSTdropdown is equal to $id (which is populated by the array)
                            foreach ($issue_type as $id => $display) {
                                echo '<option ' . (($_POST['dropdown'] == $id) ? "selected" : "") . ' value="' . $id . '" >' . $display . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>
                            Notes
                        </label>
                        <input class="form-control" type="text" name="text-box" value="<?= $notes ?>">
                    </div>

                <?php

                    $nameToInsert = $_POST['user-name'];
                    $sql = "INSERT INTO enquiries (customerName) VALUES (:customerName)";

                    $statement = $pdo->prepare($sql);

                    // column with a : before indiciate a named placeholder
                    $statement->execute([':customerName' => $nameToInsert]);

                } catch (\Exception $Exception) {
                    echo $Exception->getMessage();
                }

                ?>

                <div class="col-md-6 text-left">
                    <button class="btn btn-success" type="submit" id="submit-btn">Resubmit Form</button>
                </div>
                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-primary" id="db-btn">Save to database</button>
                </div>

            </div>
        </div>
    </form>



</body>

<script>
    $(document).on("click", "#db-btn", function() {
        $("button").each(function() {
            $(this).prop("disabled", false)
        })
    })
</script>



</html>