<?php
class Message
{

  // FILES
  public static function fileUpload()
  {
    echo "<div class='alert alert-success' role='alert'> File Uploaded </div>";
  }

  public static function fileNotUpload()
  {
    echo "<div class='alert alert-danger' role='alert'> File Not Uploaded </div>";
  }

  // USER LOGIN/CREATE ACCOUNT
  public static function userAlreadyExist()
  {
    echo "<div class='alert alert-danger' role='alert'> User Already Exist </div>";
  }

  public static function incorrectUsername()
  {
    echo "<div class='alert alert-danger' role='alert'> Incorrect Username </div>";
  }

  public static function incorrectPassword()
  {
    echo "<div class='alert alert-danger' role='alert'> Incorrect Password </div>";
  }

  public static function passwordDontMatch()
  {
    echo "<div class='alert alert-danger' role='alert'> Password Don't Match </div>";
  }

  public static function incorrectEmail()
  {
    echo "<div class='alert alert-danger' role='alert'> Incorrect Email </div>";
  }

  public static function loginFirst()
  {
    echo "<div class='alert alert-danger' role='alert'> Login First </div>";
  }
  
  public static function createAccountSuccess()
  {
    echo "<div class='alert alert-success' role='alert'> Account Created Successfully </div>";
  }

  // SUBMITTING FORMS
  public static function invalidInputs()
  {
    echo "<div class='alert alert-danger' role='alert'> Invalid Input </div>";
  }

  public static function submitSuccessfully()
  {
    echo "<div class='alert alert-success' role='alert'> Submit Successfully </div>";
  }

  public static function submitFailed()
  {
    echo "<div class='alert alert-danger' role='alert'> Failed to Submit </div>";
  }

  public static function candidateAdded()
  {
    echo "<div class='alert alert-success' role='alert'> Candidate Added </div>";
  }

  public static function candidateEdited()
  {
    echo "<div class='alert alert-success' role='alert'> Candidate Edit Successfully </div>";
  }

  public static function invalidFile()
  {
    echo "<div class='alert alert-danger' role='alert'> Invalid File </div>";
  }

  public static function voteSuccessfully()
  {
    echo "<div class='alert alert-success' role='alert'> Vote Successfully </div>";
  }

  public static function accountDeactivated($message) {
    echo "<div class='alert alert-danger' role='alert'> $message </div>";
  }

  
}

