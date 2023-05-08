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




// Declare a class that represents the `User` controller,
class UserController {

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
   * @return string - JSON representation of the user
   */
  public function get($userId): string {
    // Get the user with the specified id
    $user = $this->userModel->findById($userId);

    // return the JSON representation of the `$user` array
    return json_encode($user);
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





