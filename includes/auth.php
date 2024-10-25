<?php 

    if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
  
  header('Location: ../public/index.php');
  exit;
}

?>