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
* @name Book - Controller 
* @file BookController.php
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

// use some models
use App\Model\UserModel;
use App\Model\BookModel;




// Declare a class that represents the `Book` controller,
class BookController {

  // declare some constants..
  // pages
  const PAGE_LOGIN = 'login';
  
  // declare some properties...

  
  // private properties
  private UserModel $userModel;
  private BookModel $bookModel;


  /**
   * Constructor of the class
   * This method is executed automatically whenever this class is instantiated
   */
  public function __construct() {
    // TODO: write something awesome code here ;)
    
    // instantiate some models 
    $this->userModel = new UserModel();
    $this->bookModel = new BookModel(); 
  }



  // PUBLIC SETTERS

  // PUBLIC GETTERS


  /**
   * Method used to get a book with the specified `bookId`
   *
   * @param int $bookId - The id of the book to get
   *
   * @return string - JSON representation of the book
   */
  public function get($bookId): string {
    // Get the book with the specified id
    $book = $this->bookModel->findById($bookId);
    
    // return the JSON representation of the `$book` array
    return json_encode($book);
  }


  // PUBLIC METHODS


  /**
   * Redirects the user to a specific url
   *
   * @param string $url - the url to redirect the user to
   * @return void
   */
  public function redirect(string $url): void {
    header('Location: /' . APP_NAME . '/' . $url);
    exit();
  }

  /**
   * Method used get a list all books 
   *
   * @param bool $useCurrentUserId - Whether to use the current user id or not
   *
   * @return string - JSON representation of all books
   */
  public function list(bool $useCurrentUserId = false): string {
    // Get the current user id as `userId`
    $userId = $this->userModel->getId();

    // Get all books as `$books`
    $books = $useCurrentUserId ? $bookModel->findAll($userId) : $bookModel->findAll();
     
    // return the JSON representation of the `$books` array
    return json_encode($books, JSON_PRETTY_PRINT);
  } 


  /**
   * Method used to show the page of a book with the specified `bookId`
   *
   * @param int $bookId - The id of the book to show
   * @return void
   */
  public function showPage(?int $bookId = null): void {
    // Get the book details of the specified id as `$book`,
    // using our beloved ternary statement
    $book = (isset($bookId)) ? $this->bookModel->findById($bookId) : '';

    // Now, check if the book was found,
    // NOTE: The book is found if `$book` is not empty or false
    $bookFound = (!empty($book) || $book !== false);

    // encode the `$book` into JSON as `$bookJSON`
    $bookJSON = json_encode($book, JSON_PRETTY_PRINT);

    // embed or require the `book.php` view file
    require  __DIR__ . '/../View/book.php';
  }


  /**
   * Method used to show the list page of all books
   *
   * @return void
   */
  public function showListPage(): void {
    // Get all books as `$books`
    $books = $this->bookModel->findAll();

    // encode the `$books` into JSON as `$booksJSON`
    $booksJSON = json_encode($books, JSON_PRETTY_PRINT);

    // embed or require the `books.php` view file
    require  __DIR__ . '/../View/books.php';
  } 


  /**
   * Method used to show a page to create a new book,
   * NOTE: This page contains a form as per project requirements
   *
   * @return void
   */
  public function showCreatePage(): void {
    // If the user is not connected
    if (!$this->userModel->isConnected()) {
      // redirect the user to the login page
      $this->redirect(self::PAGE_LOGIN);
    }

    // get the first name of the current user as `$firstName`
    $firstName = $this->userModel->getFirstName();

    // embed or require the `create-book.php` view file
    require  __DIR__ . '/../View/create-book.php';
  } 


  // PRIVATE SETTERS

  // PRIVATE GETTERS

  // PRIVATE METHODS

};





