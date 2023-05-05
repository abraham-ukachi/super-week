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
* @name Auth - Controller 
* @file AuthController.php
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
// use the `ResponseHandler` controller helper
use App\Controller\Helper\ResponseHandler;




// Declare a class that represents the `Auth` controller,
class AuthController {
  // using the `ResponseHandler` controller helper / trait in this class
  use ResponseHandler;

  // declare some constants...
  
  // declare some properties...

  
  // private properties
  // private UserModel $userModel;


  /**
   * Constructor of the class
   * This method is executed automatically whenever this class is instantiated
   */
  public function __construct() {
    // TODO: write something awesome code here ;)
    
    // instantiate some models 
    // $this->userModel = new User();
     
  }



  // PUBLIC SETTERS

  // PUBLIC GETTERS

  // PUBLIC METHODS

  /**
   * Method used to register a new user
   *
   * @return bool : Returns TRUE if the user was successfully registered, FALSE otherwise
   */
  public function register(): bool {
    // Instantiate the `User` model as `$userModel`
    $userModel = new UserModel();

    // Get the request body as `$requestBody`
    $requestBody = $this->getRequestBody(true);

    // Get the email, firstName, lastName,
    // password and confirmPassword from the `$requestBody`
    $email = $requestBody['email'];
    $firstName = $requestBody['firstName'];
    $lastName = $requestBody['lastName'];
    $password = $requestBody['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $confirmPassword = $requestBody['confirmPassword'];

    // IDEA #1: Check if the user's `$password` and `$confirmPassword` match

    // If the user's `$password` and `$confirmPassword` do not match...
    if ($password !== $confirmPassword) {
      // ...update the response
      $this->updateResponse(false, self::$STATUS_ERROR_UNPROCESSABLE_ENTITY, 'Passwords do not match', [
        'email' => $email,
        'firstName' => $firstName,
        'password' => $password,
        'confirmPassword' => $confirmPassword
      ]);

      // return FALSE
      return false;
    }


    // IDEA #2: Check if the user with the `$email` already exists,
    //       using the `findByEmail()` method of the `$userModel`


    // If the user with the `$email` already exists...
    if ($userModel->findByEmail($email)) {
      // ...update the response
      // TODO: Get the user's details (e.g. firstName) directly from the database
      $this->updateResponse(false, self::$STATUS_ERROR_UNAUTHORIZED, 'User with email already exists', [
        'email' => $email,
        'firstName' => $firstName
      ]);

      // return FALSE
      return false;
    }


    // NOTE: At this point, the user with the `$email` does not exist,
    //       so we can create a new user with the `$email`, `$firstName`, 
    //       `$lastName` and `$password` --- HURRAY !!!
    
    // Create a new user with the `$email`, `$firstName`, `$lastName` and `$hashedPassword`
    $user = $userModel->create($email, $firstName, $lastName, $hashedPassword);
     
    // If the user was successfully created (i.e. `$user` is an array)...
    if (is_array($user)) {
      // ...update the response with the user's details (especially his/her `id`)
      $this->updateResponse(true, self::$STATUS_SUCCESS_CREATED, 'User created successfully', $user);
      
      // return TRUE
      return true;

    } else { // <- user was not created
      // ...update the response with the user's details (especially his/her `id`)
      $this->updateResponse(false, self::$STATUS_ERROR_UNPROCESSABLE_ENTITY, 'Failed to create user');
      
      // return FALSE
      return false;
    }


  } 
   
 
  /**
   * Method used to login a registered user
   *
   * @return bool : Returns TRUE if the user was logged in successfully, FALSE otherwise
   */
  public function login(): bool {
    // Instantiate the `User` model as `$userModel`
    $userModel = new UserModel();

    // Get the request body as `$requestBody`
    $requestBody = $this->getRequestBody(true); // <- from POST

    // Get the email and password,
    $email = $requestBody['email'];
    $password = $requestBody['password'];
    

    // Connecting the user...

    // Connect the user with the `$email` and `$password` and assign the result to `$user`
    $user = $userModel->connect($email, $password);
    $userIsConnected = is_array($user); // <- The user is connected if `$user` is an array #codeReadability ;)


    // If the user was successfully connected...
    if ($userIsConnected) {
      // ...update the response with the user's details (especially his/her `id`)
      $this->updateResponse(true, self::$STATUS_SUCCESS_OK, 'User logged in successfully', $user);
      
      // return TRUE
      return true;

    } else { // <- user was not connected
      // ...update the response accordingly
      $this->updateResponse(false, self::$STATUS_ERROR_UNAUTHORIZED, 'Wrong email or password');
      
      // return FALSE
      return false;
    }

  } 
   


  
  // PRIVATE SETTERS

  // PRIVATE GETTERS
  
  // PRIVATE METHODS
  
  /**
   * Method used to get the request body
   *
   * @param bool $fromPOST : If TRUE, the request body will be gotten from `$_POST`, otherwise, it will be gotten from `php://input`
   *
   * @return array|bool : Returns the request body as an array if it is not empty, FALSE otherwise
   */
  private function getRequestBody($fromPOST = false) {
    // Get the request body as `$requestBody`
    $requestBody = ($fromPOST) ? $_POST : json_decode(file_get_contents('php://input'), true);

    // If the request body is empty...
    if (empty($requestBody)) {
      // ...update the response
      $this->updateResponse(false, self::$STATUS_ERROR_UNPROCESSABLE_ENTITY, 'Request body is empty');

      // return FALSE
      return false;
    }


    // TODO: Validate all the items in the request body

    // return the request body
    return $requestBody;
  }


};





