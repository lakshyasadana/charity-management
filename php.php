<!doctype html>
<?php
session_start();
if(!isset($_SESSION['user']))
{
    header('Location: ./userlogin.php');
    exit;
}
?>
<?php
if(isset($_POST['login'])){
    // Authorisation details.
    $username = "kattaakhil0017@gmail.com";
    $hash = "a0db765f08c425678cbc876149246d121dd567afeb6faf83b843bf394537999a";

    // Config variables. Consult http://api.txtlocal.com/docs for more info.
    $test = "+";
    $name=$_POST['name'];

    // Data for text message. This is the text message data.
    $sender = "Akhil"; // This is who the message appears to be from.
    $numbers = $_POST['num'];	// A single number or a comma-seperated list of numbers
    $otp = mt_rand(100000,999999);
    setcookie("otp", $otp);
    $message = "Hey ".$name. " your OTP is ".$otp;
    // 612 chars or less
    // A single number or a comma-seperated list of numbers
    $message = urlencode($message);
    $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
    $ch = curl_init('http://api.txtlocal.com/send/?');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch); // This is the result from the API
    echo " OTP SENT SUCCESSFULLY";
    curl_close($ch);
}
if(isset($_POST['ver'])){
    $verotp=$_POST['otp'];
    if($verotp==$_COOKIE['otp']){
        header('Location:news.html');
	echo '<script>alert("Thanks a lot for donating the victims of the incidents...");</script>';}
    else{
        echo '<script>alert("OTP NOT MATCHED");</script>';
    }
}
?>
<html>
<head>
    <meta charset="utf-8">
    <title>OTP</title>
    <style>
        table{
            margin-top: 200px;
        }
        tr,td{
            padding: 10px;
        }
    </style>
</head>

<body>
<form method="post" action="php.php">

    <table align="center">
        <tr>
            <td>Name:</td>
            <td><input type="text" name="name" placeholder="enter your Name"></td>
        </tr>
        <tr>
            <td>Valid Phone Number:</td>
            <td><input type="text" name="num" placeholder="enter valid number"></td>
        </tr>
        <tr>
            <td>send code</td>
            <td><input type="submit" name="login" value="CLICK HERE"></td>
        </tr>

        <tr>
            <td>Verify OTP:</td>
            <td><input type="text" name="otp"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="ver" value="Verify"></td>
        </tr>
    </table>
</form>
</body>
</html>