<?php
/**
* @license MIT
* super-week
*
* Copyright (c) 2023 Abraham Ukachi
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*
* @project super-week
* @name User Model
* @test test/user_model.php
* @file UserModel.php
* @author: Abraham Ukachi <abraham.ukachi@laplateforme.io>
* @version: 0.0.1
* 
* Example usage:
*   
*   1+|> // Get all users using the `findAll()` method
*    -|> 
*    -|> $user = new App\Model\User();
*    -|> $allUsers = $user->findAll();
*    -|> 
*/


// declare a namespace for this User class
namespace App\Model;


// use these classes
use App\Model\Helper\Database;
use pdo;
// use datetime;
// use PDO;
// use PDOException;


// create a User class that extends the Database class
class UserModel extends Database {

  // Declare some constants


  // Declare some public properties
  public ?int $id = null;
  public ?string $email = null;
  public ?string $firstname = null;
  public ?string $lastname = null;


  // Declare some private properties

  /**
   * User constructor.
   * NOTE: This constructor is called when a new instance of the User class is created
   */
  public function __construct() {
    // call the parent/Database constructor
    parent::__construct(Database::TYPE_PDO); // <- via PDO

    // connect to the database 
    $this->dbConnection();

  }


  // PUBLIC SETTERS
  // PUBLIC GETTERS
  // PUBLIC METHODS


  /**
   * Method used to find all the users in the database
   *
   * @return array - an associative array of all the users in the database
   */
  public function findAll(): array {
    // create an as sql query named `find_users_query`,
    // using a heredoc syntax - https://www.php.net/manual/en/language.types.string.php#language.types.string.syntax.heredoc
    $find_users_query = <<<SQL
      SELECT * FROM users
    SQL;

    // prepare the `find_users_query` as a PDO statement
    $pdo_stmt = $this->pdo->prepare($find_users_query);

    // execute our PDO statement
    $pdo_stmt->execute();

    // fetch all the results from `pdo_stmt` as an associative array
    $results = $pdo_stmt->fetchAll(PDO::FETCH_ASSOC);

    // return the results
    return $results;
  }








  // PRIVATE SETTERS
  // PRIVATE GETTERS
  // PRIVATE METHODS


  

}


