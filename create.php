<!DOCTYPE HTML>
<html>

<head>
    <title>MINI PHP</title>

    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

</head>

<body>

    <!-- container -->
    <div class="container">

        <div class="page-header">
            <h1>Create Product</h1>
        </div>

        <?php
        if ($_POST) {

            // database connection
            include 'config/database.php';

            try {

                // insert query
                $query = "INSERT INTO products SET name=:name, description=:description, price=:price, created=:created, images=:images, status=:status, videos=:videos";

                // prepare query for execution
                $stmt = $con->prepare($query);

                // posted values
                $name = htmlspecialchars(strip_tags($_POST['name']));
                $description = htmlspecialchars(strip_tags($_POST['description']));
                $price = htmlspecialchars(strip_tags($_POST['price']));
                $created = date('Y-m-d H:i:s');

                if (!empty($_POST['status'])) {
                    $status = htmlspecialchars(strip_tags($_POST['status']));
                } else {
                    $status = "Inactive";
                }

                // bind the parameters
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':created', $created);
                $stmt->bindParam(':images', $images);
                $stmt->bindParam(':videos', $videos);
                $stmt->bindParam(':status', $status);

                // Upload Images          
                if(!empty($_FILES['image']['name'])){
                    // Upload images to folder
                    $folder = "uploads/images/";
                    // $images = $_FILES["image"]["name"];
                    $imga = random_int(000, 99999);
                    $images = $imga . ".jpg";

                    $path = $folder . $images;

                    $target_file = $folder . basename($_FILES["image"]["name"]);

                    $imageFileType = pathinfo(
                        $target_file,
                        PATHINFO_EXTENSION
                    );
                    // Select file type
                    // $videoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    $allowed = array('jpeg', 'png', 'jpg');
                    $filename = $_FILES['image']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if (!in_array($ext, $allowed)) {

                        echo "Sorry, only JPG, JPEG, PNG & GIF  files are allowed.";
                    } else {

                        move_uploaded_file($_FILES['image']['tmp_name'], $path);
                    }
                } else{
                    $images = '';
                }

                // Uploads videos
                if (!empty($_FILES['video']['name'])) {
                    $maxsize = 5242880; // 5MB
                    $pathVideos = "uploads/videos/";
                    $videos = $_FILES['video']['name'];
                    $target_video = $pathVideos . $_FILES["video"]["name"];
                    // Select file type
                    $videoFileType = strtolower(pathinfo($target_video, PATHINFO_EXTENSION));
                    // Valid file extensions
                    $extensions_arr = array("mp4", "avi", "3gp", "mov", "mpeg");
                    // Check extension
                    if (in_array($videoFileType, $extensions_arr)) {

                        // Check file size
                        if (($_FILES['video']['size'] >= $maxsize) || ($_FILES["video"]["size"] == 0)) {
                            echo "File too large. File must be less than 5MB.";
                        } else {
                            // Upload
                            move_uploaded_file($_FILES['video']['tmp_name'], $target_video);
                        }
                    } else {
                        echo "Invalid file extension.";
                    }
                }else {
                    $videos = "";
                }

                // Execute the query
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Record was saved.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Unable to save record.</div>";
                }
            }
            //error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control'></textarea></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Image</td>
                    <td><input type='file' name='image'' class=' form-control' /></td>
                </tr>
                <tr>
                    <td>Videos</td>
                    <td><input type='file' name='video'' class=' form-control' /></td>
                </tr>

                <td>Status</td>
                <td><input type='checkbox' name='status' value="Active" /> Active</td>

                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='index.php' class='btn btn-danger'>Back to index</a>
                    </td>
                </tr>
            </table>
        </form>

    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>

</html>