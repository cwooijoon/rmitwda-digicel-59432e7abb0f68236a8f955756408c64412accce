<?php

require_once(LIBRARY_PATH . DS . 'Database.php');

/**
 * This is the User class.
 *
 * @author donal.ellis@rmit.edu.au
 */
class User {

  /**
   * If validation fails, errors are written to this variable.
   */
  private static $errors;

  /**
   * A method for validating the data
   *
   * @param $data An array of POSTed data.
   * @return bool Whether the data is valid or not.
   */
  public static function validates(array &$data) {
    $errors = array();

    // error checks from specific to general
    // error check for name input type
    if (!preg_match("/^[a-z ]+$/i", $data['name'])) {
      $errors['name'] = 'Your name must only be characters';
    }
    if (!isset($data['name']) || empty($data['name'])) {
      $errors['name'] = 'You must provide your name';
    }
    // only unset the name data after checking for all errors
    if (isset($errors['name'])) {
      unset($data['name']);
    }
    
    // error check for email pattern
    if(!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9][a-zA-Z0-9.-]*[\.]{1}[a-zA-Z]{2,4}$/", $data['email'])) {
	$errors['email'] = 'Your email is not valid';
    }	
    if (!isset($data['email']) || empty($data['email'])) {
      $errors['email'] = 'You must provide your email';
    }
    // only unset the email data after checking for all errors
    if(isset($errors['email']) || !empty($errors['email'])) {
	unset($data['email']);
    }
    
    // error check for username input type
    if (!preg_match("/^[a-z]+$/i", $data['username'])) {
      $errors['username'] = 'Your username must only be characters';
    }
    if (!isset($data['username']) || empty($data['username'])) {
      $errors['username'] = 'You must provide your username';
    }
    // only unset the username data after checking for all errors
    if (isset($errors['username'])) {
      unset($data['username']);
    }
    
    // error check for password input type
    if (!isset($data['password']) || empty($data['password'])) {
      $errors['password'] = 'You must provide your password';
      unset($data['password']);
    }

    self::$errors = $errors;
    if (count($errors)) {
      return false;
    }
    return true;
  }

  /**
   * Returns any validation errors.
   *
   * @return array An array of errors, or an empty array.
   */
  public static function errors() {
    return self::$errors;
  }

  /**
   * A method for retrieving users from the users table.
   *
   * @param array $data An optional array of key:value pairs to be used as
   *                    parameters in the SQL query.
   * @return array An array of database Objects where each Object represents a
   *               user.
   */
  public static function retrieve(array $data = array()) {

    $sql = 'SELECT * FROM user';
    $values = array();
    if (count($data)) {
      $count = 0;
      foreach ($data as $key => $value) {
        if ((++$count) == 1) {
          $sql .= " WHERE {$key} = ?";
          $values[] = $value;
        } else {
          $sql .= " AND {$key} = ?";
          $values[] = $value;
        }
      }
    }

    try {
      $database = Database::getInstance();

      $statement = $database->pdo->prepare($sql);

      $statement->execute($values);
      // result is FALSE if no rows found
      $result = $statement->fetchAll(PDO::FETCH_OBJ);

      $database->pdo = null;
    } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
    }
    if (count($result) > 1) {
      return $result;
    } else if (count($result) == 1) {
      return $result[0];
    } else {
      return NULL;
    }
  }

  /**
   * Writes a new row to the users table based on given data.
   *
   * @param array $data The POSTed data.
   * @return int Returns id of the inserted row (or throws an Exception)
   */
  public static function create(array $data) {
    // TODO could do a check here to ensure data exists

    // assumes all new users will not be admin
    $sql  = 'INSERT INTO user (name, email, username, password, account_type_id) VALUES (?, ?, ?, ?, 2)';
    $values = array(
      $data['name'],
      $data['email'],
      $data['username'],
      $data['password']
    );

    try {
      $database = Database::getInstance();

      $statement = $database->pdo->prepare($sql);
      $return = $statement->execute($values);

      if ($return) {
        $id = $database->pdo->lastInsertId();
      }
      $database->pdo = null;
    } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
    }
    if ($return) {
      return $id;
    }
    return false;
  }

  /**
   * Updates an existing row in the users table based on given data.
   *
   * @param int $id The row id of the user to update.
   * @param array $data The POSTed data.
   * @return int bool Whether update was successful or not.
   */
  public static function update($user_id, array $data) {
    // TODO could do a check here to ensure data exists

    // assumes all new users will not be admin
    $sql  = 'UPDATE user SET name = ?, email = ?, username = ?, password = ?  WHERE user_id = ?';
    $values = array(
      $data['name'],
      $data['email'],
      $data['username'],
      $data['password'],
      $user_id
    );

    try {
      $database = Database::getInstance();

      $statement = $database->pdo->prepare($sql);
      $return = $statement->execute($values);

      $database->pdo = null;
    } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
    }
    return $return;
  }

  /**
   * An example private method to show the @access tag for PhpDocumentor.
   *
   * @access private
   */
  private static function sanitise() {

  }

}