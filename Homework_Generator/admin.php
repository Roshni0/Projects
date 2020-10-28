<?php
  require "user.php";
  class admin extends user {
    function __constructu ($username,$password){
      parent::__construct($username,$password);
    }
  }
 ?>
