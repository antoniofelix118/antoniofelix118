<?php
  include 'connect.php';
  session_start();

  // Get Data from DB
  $conn = getDatabaseConnection("ottermart");
  $namedParameters = array();
  
  $namedParameters[":email"] = $_GET['email'];
  
  $sql = "SELECT * FROM user " .
         "WHERE email = :email ";
  
$stmt = $conn->prepare($sql);
$stmt->execute($namedParameters);
$record = $stmt->fetch();

  
  $isAuthenticated = password_verify($_GET["password"], $record["password"]);
    
  if ($isAuthenticated) {
    $_SESSION["email"] = $record["email"];
    $_SESSION["isAdmin"] = $record["is_admin"];
  }
  
  // Allow any client to access
  header("Access-Control-Allow-Origin: *");
  // Let the client know the format of the data being returned
  header("Content-Type: application/json");

  // Sending back down as JSON
  echo json_encode(array("isAuthenticated" => $isAuthenticated));
?>
