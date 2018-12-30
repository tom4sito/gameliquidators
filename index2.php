<?php 
// echo session_id();
// echo SID;  // bool(false) - Not defined...
session_start();
// echo SID;  // bool(true) - Defined now!
echo session_id();
?>