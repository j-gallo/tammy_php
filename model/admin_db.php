<?php

/***************************************
 *  This is a collection of functions that modify the "admins" SQL table
 ***************************************/   

/*This function takes two string parameters and creates 
  an entry in the "admins" table.*/
function create_admin($name, $password){
  global $db;
  //If either parameter is blank, throw an error and don't save.
  if($name == '' || $password == ''){
    return 'error';
  }
  /*encrypt the local time, append it to the given password, and 
    encrypt the result. Then, save the salt (encrypted time) in the
    database along with the name and encrypted password*/
  $salt = hash('sha256', time());
  $enc_password = hash('sha256', $password . $salt);
  $query = 'INSERT INTO admins (name, salt, enc_password) VALUES (:name, :salt, :password)';
  $stmt = $db->prepare($query);
  $stmt->bindValue(':name', $name);
  $stmt->bindValue(':salt', $salt);
  $stmt->bindValue(':password', $enc_password);
  $stmt->execute();
  $stmt->closeCursor();
}

/*this function takes two string parameters and verifies them against
   the 'admins' database. If verified, the function returns true for
   the variable 'valid' and the 'logged_in' session variable is set
   to true by the controller*/
function login($name, $password){
  global $db;
  /*select the column from the admin table with the supplied name. If the
    name doesn't exist in the table, return false for variable 'valid'.*/
  $query = 'SELECT salt, enc_password FROM admins WHERE name = :name';
  $stmt = $db->prepare($query);
  $stmt->bindValue(':name', $name);
  $stmt->execute();
  $data = $stmt->fetch(PDO::FETCH_BOTH);
  if ($data == ''){
    return $valid = false;
  }
  /*grab the salt from the returned table, append to supplied password, and
    encrypt. If the encrypted supllied password matches the encrypted stored
    password, return true for the variable 'valid'. otherwise, return false.*/
  $salt = $data['salt'];
  $enc_password = hash('sha256', $password . $salt);
  $password_db = $data['enc_password'];
  if ($enc_password == $password_db){
    return $valid = true;
  }
  else{
    return $valid = false;
  }

}
?>
