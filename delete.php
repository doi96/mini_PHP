<?php
    // include database connection
    include 'config/database.php';
    
    try {
        
        // get record ID
        $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
    
        // delete query
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $id);

        $img = $con->prepare("SELECT `images` FROM `products` WHERE id=:id");
        $img->bindParam(":id",$id);
        $img->execute();
        $row = $img->fetch(PDO::FETCH_ASSOC);
        $images = $row['images'];

        unlink("uploads/".$images);
        
        if($stmt->execute()){
            // redirect to read records page and 
            // tell the user record was deleted 
            header('Location: index.php?action=deleted');
        }else{
            die('Unable to delete record.');
        }
    } catch(PDOException $exception){
    echo 'ERROR: ' . $exception->getMessage();
    }

?>
