
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="review.css">
</head>
<body>
    <form action="reviewDb.php" method="POST">
        
            <h1>...Because your valuable Feedback Matters</h1>
           
        <input type="text" class="username" id="username" placeholder="Enter your Name here" name="username"><br><br>

        
        <input type="text" class="email" id="email" placeholder="Enter email or phone number" name="email"><br><br>

        
        <textarea placeholder="Write your Feedback ..." class="message" name="message"></textarea>
        <br><br>
        <input type="submit" value="Submit" class="btn">
        
        
    </form>

 <!-- Display Feedback -->
 <h1 style="color: rgb(244, 141, 23);">Older Feedbacks</h1>
    <div class="comments-container">
        <?php
        $server = "localhost";
        $username = "root";
        $password = "";
        $dbname = "feedback";

        $conn = new mysqli($server, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
        }
        $sql = "SELECT * FROM greetings";
        $query = $conn->query($sql);
        while ($row = $query->fetch_assoc()) {
            ?>
            <div class="comment">
                <h4><?php echo $row['username']; ?> <span><?php echo $row['email']; ?></span></h4>
                <p><?php echo $row['message']; ?></p>
            </div>
        <?php
        }
        ?>
    </div>

    <script src="review.js"></script>
</body>
</html>