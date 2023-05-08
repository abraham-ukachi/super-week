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
* @name Logout - Controller 
* @file LogoutController.php
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



// Declare a class that represents the logout controller,
class LogoutController {
  // using the `ResponseHandler` controller helper / trait in this class
  use ResponseHandler;
  
  // declare some constants...

  // pages
  const PAGE_LOGIN = 'login';
  const PAGE_HOME = 'home';
  
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

    // If the user is not logged in or connected...
    if (!$this->userModel->isConnected()) {
      // redirect the user to the login page
      $this->redirect(PAGE_LOGIN);
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
   * Method used to logout the user
   *
   * @param bool $redirectToHome - if true, the user will be redirected to the home page after logout
   *
   * @return bool - Returns TRUE if the user is successfully logged out, otherwise FALSE
   */
  public function logoutUser($redirectToHome = false): bool {
    // disconnect the user and return the result as `isUserDisconnected`
    $isUserDisconnected = $this->userModel->disconnect();

    // if the user has been disconnected...
    if ($isUserDisconnected) {
      // ..update the response accordingly ;)
      $this->updateResponse(true, self::$STATUS_SUCCESS_OK, 'logout successful');

    }else { // <- user not disconnected
      // ..update the response accordingly ;)
      $this->updateResponse(false, self::$STATUS_ERROR_INTERNAL_ERROR, 'logout failed');
    }

    // if the user should be redirected to the home page...
    if ($redirectToHome) {
      // redirect the user to the home page
      $this->redirect(PAGE_HOME);
    }

    // returns the `isUserDisconnected` result
    return $isUserDisconnected;
  }


  /**
   * Shows the logout page
   *
   * @return void
   */
  public function showPage(): void {
    // get the user's fullname
    $fullname = $this->userModel->getFullname();

    // require or include the logout page from the `View` folder 
    require __DIR__ . '/../View/logout.php';

  }


  
  
  // PRIVATE SETTERS

  // PRIVATE GETTERS

  // PRIVATE METHODS

};





