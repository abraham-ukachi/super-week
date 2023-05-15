<?php
/**
* @license MIT
* super-week
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
* @name User - Controller 
* @file UserController.php
* @author: Abraham Ukachi <abraham.ukachi@laplateforme.io>
* @version: 0.0.1
* 
* Usage:
*   1+|> //
*    -|> 
*/


/*
* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
* MOTTO: I'll always do more 😜 !!!
* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
*/


// declare the namespace for this controller
namespace App\Controller;

// use the `User` model
use App\Model\UserModel;
// use the `ResponseHandler` controller helper trait
use App\Controller\Helper\ResponseHandler;




// Declare a class that represents the `User` controller,
class UserController {
  use ResponseHandler;

  // declare some constants...
  
  // declare some properties...

  
  // private properties
  private UserModel $userModel;


  /**
   * Constructor of the class
   * This method is executed automatically whenever this class is instantiated
   */
  public function __construct() {
    // TODO: write something awesome code here ;)
    
    // instantiate some models
    $this->userModel = new UserModel();
    
  }



  // PUBLIC SETTERS

  // PUBLIC GETTERS


  /**
   * Method used to get a user with the specified `userId`
   *
   * @param int $userId - The id of the user to get
   *
   * @return array - Array representation of the user, or `false` if no user was found
   */
  public function get(int $userId): array|false {
    // Get the user with the specified id
    $user = $this->userModel->findById($userId);

    // If no user was found...
    if (!$user) {
      // ...update the response accordingly
      $this->updateResponse(false, self::$STATUS_ERROR_NOT_FOUND, 'No user found', ['user' => []]);

    }else { // <- a user was found
      // ...update the response accordingly
      $this->updateResponse(true, self::$STATUS_SUCCESS_OK, 'User info retrieved successfully', ['user' => $user]);
    }

    // return the `user`
    return $user;
  }




  public function getInfo(int $userId): array { 
    // TODO: Use a try-catch block to catch any errors that may occur
    
    // Get the user info as `$user`
    $info = $this->userModel->findAll();

    // update the response
    $this->updateResponse(true, self::$STATUS_SUCCESS_OK, 'User info retrieved successfully', ['info' => $info]);

    // return `users`
    return $users;
  }

  /**
   * Method used get a list of all users
   * NOTE: This is similar to the `list()` method below, 
   *       but this returns an array instead of a JSON string
   *
   * @return array - Array representation of all users
   */
  public function getAll(): array {
    // TODO: Use a try-catch block to catch any errors that may occur

    // Get all users as `$users`
    $users = $this->userModel->findAll();


    // If no users were found...
    if (!$users) {
      // ...update the response accordingly
      $this->updateResponse(false, self::$STATUS_ERROR_NOT_FOUND, 'No users found', ['users' => []]);

    }else { // <- books were found
      // ...update the response accordingly
      $this->updateResponse(true, self::$STATUS_SUCCESS_OK, 'Users retrieved successfully', ['users' => $users]);
    }

    // update the response
    // $this->updateResponse(true, self::$STATUS_SUCCESS_OK, 'Users retrieved successfully', ['users' => $users]);

    // return `users`
    return $users;
  } 


  // PUBLIC METHODS

  /**
   * Method used get a list all users
   *
   * @return string - JSON representation of all users
   */
  public function list(): string {
    // Instantiate the `User` model as `$userModel`
    $userModel = new UserModel();

    // Get all users as `$users`
    $users = $userModel->findAll();

    // return the JSON representation of the `$users` array
    return json_encode($users, JSON_PRETTY_PRINT);
  } 



  /**
   * Method used to show the list page of all users
   *
   * @param array|null $users - The list of users to show
   *
   * @return void
   */
  public function showListPage(?array $users = null): void {
    // Create a welcome message
    $welcomeMessage = "Welcome to the User's list";

    // Get a list of all users as `$usersList`
    $usersList = $users ? json_encode($users, JSON_PRETTY_PRINT) : $this->list();

    // Embed or require the `users.php` view file
    require __DIR__ . '/../View/users.php';
  }




  /**
   * Method used to get a user with the specified `userId`
   *
   * @param int $userId - The id of the user to get
   * @return void
   */
  public function showPage(?int $userId = null): void {
    // Get the user details of the specified id as `$user`,
    // using our beloved ternary statement
    $user = (isset($userId)) ? $this->userModel->findById($userId) : '';

    // Now, check if the user was found,
    // NOTE: The user is found if `$user` is not empty or false
    $userFound = (!empty($user) || $user !== false);

    // encode the `$user` into JSON as `$userJSON`
    $userJSON = json_encode($user, JSON_PRETTY_PRINT);

    // embed or require the `user.php` view file
    require  __DIR__ . '/../View/user.php';
  } 
  
  
  // PRIVATE SETTERS

  // PRIVATE GETTERS

  // PRIVATE METHODS

};





