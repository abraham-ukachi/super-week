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
// use some controller helpers
use App\Controller\Helper\ResponseHandler;


// use some PHP's core classes
use Exception;








// Declare a class that represents the `Book` controller,
class BookController {
  // using the `ResponseHandler` controller helper / trait in this class  
  use ResponseHandler;


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
   * @return array - Array representation of the book, or `false` if no book was found
   */
  public function get($bookId): array|false {
    // Get the book with the specified id
    $book = $this->bookModel->findById($bookId);

   
    // If no book was found...
    if (!$book) {
      // ...update the response accordingly
      $this->updateResponse(false, self::$STATUS_ERROR_NOT_FOUND, 'No book found', ['book' => []]);

    }else { // <- a book was found
      // ...update the response accordingly
      $this->updateResponse(true, self::$STATUS_SUCCESS_OK, 'Book retrieved successfully', ['book' => $book]);
    }

    // return the `book`
    return $book;

    // return the JSON representation of the `$book` array
    // return json_encode($book);
  }

  /**
   * Method used get a list of all books 
   * NOTE: This is similar to the `list()` method below, 
   *       but this returns an array instead of a JSON string
   *
   * @return array - Array representation of all users
   */
  public function getAll(): array {
    // TODO: Use a try-catch block to catch any errors that may occur

    // Check if the user is connected as `userIsConnected`
    $userIsConnected = $this->userModel->isConnected();

    // Get the user's id as `userId`
    $userId = $userIsConnected ? $this->userModel->getId() : null;

    // Get all books of a specific the user as `$books` if he/she is connected, else get all public books
    $books = $userIsConnected ? $this->bookModel->findAll($userId) : $this->bookModel->findAll();

    // If no books were found...
    if (!$books) {
      // ...update the response accordingly
      $this->updateResponse(false, self::$STATUS_ERROR_NOT_FOUND, 'No books found', ['books' => []]);

    }else { // <- books were found
      // ...update the response accordingly
      $this->updateResponse(true, self::$STATUS_SUCCESS_OK, 'Books retrieved successfully', ['books' => $books]);
    }

    // return `books`
    return $books;
  }


  /**
   * Method used to create a new book
   *
   * @return bool - Whether the book was created sucessfully or not
   */
  public function write(): bool {
    // If the user is not connected...
    if (!$this->userModel->isConnected()) {
      // ...redirect the user to the login page
      $this->redirect(self::PAGE_LOGIN);
    }

    // Initialize the `result` boolean variable as `false`
    $result = false;

    // Let's try to create a new book
    try {

      // Get the current user id as `userId` 
      $userId = $this->userModel->getId();

      // Get the request body as `$requestBody`
      $requestBody = $this->getRequestBody(true); // <- TRUE = from POST

      // Get the book's title and content from `$requestBody` as `$bookTitle` and `$bookContent` respectively
      $bookTitle = $requestBody['title'];
      $bookContent = $requestBody['content'];


      // Create a new book with the above details
      $newBook = $this->bookModel->create($bookTitle, $bookContent, $userId);

      // a book was created if `$newBook` is an array and it's length is greater than 0
      $bookCreated = is_array($newBook) && count($newBook) > 0;
      
      // If the book was created successfully...
      if ($bookCreated) {
        // ...update the `result` variable to `true`
        $result = true;

        // ...and update the response accordingly
        $this->updateResponse(true, self::$STATUS_SUCCESS_CREATED, 'Book created successfully', $newBook);
      }else {
        // ...else, update the response accordingly
        $this->updateResponse(false, self::$STATUS_ERROR_UNPROCESSABLE_ENTITY, 'An error occured while creating the book');
      }


    } catch (Exception $e) {
      // If an error occured, update the response accordingly
      $this->updateResponse(false, self::$STATUS_ERROR_INTERNAL_ERROR, $e->getMessage());
    }

    // return `result`
    return $result;
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
   * @param array|null $books - The list of books to show
   *
   * @return void
   */
  public function showListPage(?array $books = null): void {
    // Get the user id as `userId`, if the user is connected 
    $userId = $this->userModel->isConnected() ? $this->userModel->getId() : null;

    // Get all books as `$books`
    $books = $books ?? $this->bookModel->findAll($userId);

    // Get the total number of books as `$totalBooks`
    $totalBooks = count($books);

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




  // PRIVATE METHODS

};





