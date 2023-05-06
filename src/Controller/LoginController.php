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
* @name Login - Controller 
* @file LoginController.php
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

// use the `UserModel` class
use App\Model\UserModel;
// use the `ResponseHandler` controller helper
use App\Controller\Helper\ResponseHandler;



// Declare a class that represents the login controller,
class LoginController {
  // using the `ResponseHandler` controller helper / trait in this class
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
    
    // instantiate some model class as `userModel` 
    $this->userModel = new UserModel(); // <-- user model

    // If the user is already logged in or connected...
    if ($this->userModel->isConnected()) {
      // redirect the user to the home page
      $this->redirect('home');
    }

  }



  // PUBLIC SETTERS

  // PUBLIC GETTERS

  // PUBLIC METHODS


  /**
   * Redirects the user to a specific url
   *
   * @param string $url - the url to redirect the user to
   * @return void
   */
  public function redirect(string $url): void {
    header('Location: ' . $url);
    exit();
  }
  

  /**
   * Shows the login page
   *
   * @return void
   */
  public function showPage(): void {
    // require or include the login page from the `View` folder 
    require __DIR__ . '/../View/login.php';
  }


  
  
  // PRIVATE SETTERS

  // PRIVATE GETTERS

  // PRIVATE METHODS

};





