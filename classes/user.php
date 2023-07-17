<?php 
  class User {
    
    public static function ifLogin($get, $path) {
      if(isset($_SESSION["$get"])) {
        header("location: $path");
      }
    }

    public static function ifNotLogin($get, $path) {
      if(!isset($_SESSION["$get"])) {
        header("location: $path");
      }
    }

    public static function printGet($name_of_get) {
      if(isset($_GET["$name_of_get"])) {
        echo $_GET["$name_of_get"];
      }
    }
    
    public static function returnValueGet($name_of_get) {
      if(isset($_GET["$name_of_get"])) {
        return $_GET["$name_of_get"];
      }
    }

    public static function printSession($name_of_session) {
      if(isset($_SESSION["$name_of_session"])) {
        echo $_SESSION["$name_of_session"];
      }
    }




    public static function returnValueSession($name_of_session) {
      if(isset($_SESSION["$name_of_session"])) {
        return $_SESSION["$name_of_session"];
      }
    }

    public static function activeLink($name_of_get, $value_of_get, $color) {
      if($_GET["$name_of_get"] == "$value_of_get") {
        echo "style='background-color: $color' ";
      }
    }

    public static function ifGetNotIssetReturnTo($name_of_get, $return_to) {
      if (!isset($_GET["$name_of_get"])) {
        header("location: $return_to");
      } else if ($_GET["$name_of_get"] == '' || $_GET["$name_of_get"] == NULL) { {
          header("location: $return_to");
        }
      }
    }

    public static function logout() {
      session_start();
      session_unset();
      session_destroy();
    }
  
  }
