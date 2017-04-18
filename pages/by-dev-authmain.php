<?php
if (isset($_POST['userid']) && isset($_POST['password'])) {
  // if the user has justed tried to log in
  $userid = strtoupper($_POST['userid']);
  $password = $_POST['password'];
  
  $db_conn = new mysqli('sql', 'demoUser', 'demoPassword','MAB_TRACK');
  if (mysqli_connect_errno()) {
    echo 'Connection to database failed:' . mysqli_connect_error();
    exit();
  }
  $query = "SELECT au.Fname, au.Fname, au.User_ID, aup.Password 
  FROM aca_user as au, aca_user_password as aup 
  WHERE au.Fname = '" . $userid . "' AND au.Type = 'ADMINISTRATOR' AND au.User_ID = aup.User_ID AND aup.Password=sha1('".$password."')";
  $result = $db_conn->query($query);
  if ($result->num_rows) {
    // if they are in the database register the user id
    $row = $result->fetch_assoc();
    if ($row['Fname'] == $userid) {
      $_SESSION['valid_user'] = $userid;
    } else {
      echo "UserName <font color=\"red\"><b>" . $userid . "</b> </font>" . " <ins>Not Found</ins>";
    }
  } else {
    //echo "THIS IS THE QUERY    :" . $query; // debug
  }
  $db_conn->close();
}
?>
<!DOCTYPE html>

  <head>
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="mystyle.css">
    </head>
  <body>
    <h1> Authentication Required</h1>
    <?php
    if (isset($_SESSION['valid_user'])) {
    echo '<p>You are logged in as: '. $_SESSION['valid_user'] . ' <br />';
    echo '<a href="/?page=by-dev-logout">Log Out</a></p>';
    } else {
      if (isset($userid)) {
        // if they've tried and failed to log in
        echo '<p>Could not log you in.</p>';
      } else {
        // they have not tried to log in yet or have logged out
        echo '<p>You are not logged in.</p>';
      }
      // provide form to log in
      echo '<form action="/?page=by-dev-authmain" method="post">';
      echo '<fieldset>';
      echo '<legend>Login Now!</legend>';
      echo '<p><label for="userid">UserID:</label>';
      echo '<input type="text" name="userid" id="userid" size="30"/></p>';
      echo '<p><label for="password">Password:</label>';
      echo '<input type="password" name="password" id="password" size="30"/></p>';
      echo '<fieldset>';
      echo '<button type="submit" name="login">Login</button>';
      echo '</form>';
    }                        
    ?>
    <p><a href="members_only.php">Go to Members Section</a></p>  
  </body>