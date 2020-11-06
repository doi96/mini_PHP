<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h4>Hello <?php echo $_GET["username"] ?></h4>
    <br>
    <br>
    <label>Status</label>
    <form>
        <textarea name="status"></textarea><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>