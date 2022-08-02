<?php
$names = $_POST['names'];
$number = $_POST['number'];
$email = $_POST['email'];
$message = $_POST['message'];

if(!empty($names) || !empty($number) || !empty(email) || !empty(message)){
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "review";
    //connect connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if(mysqli_connect_error()){
        die('Connect Error('. mysqli_connect_error().')'. mysqli_connect_error());
    } else{
        $SELECT = "SELECT email From feedback Where email = ? Limit 5";
        $INSERT = "INSERT Into feedback (names, number, email, message) values(?, ?, ?, ?)";
        //prepare statement
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum==0) {
            $stmt->close();

            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("siss", $names, $number, $email, $message);
            $stmt->execute();
            echo "New record inserted successfully";
        } else{
            echo "You've reached the limit";
        }
        $stmt->close();
        $conn->close();
    }
} else{
    echo "All field required";
    die();
}
?>