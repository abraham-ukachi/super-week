/* 
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
* @name: App
* @type: Script
* @author: Abraham Ukachi <abraham.ukachi@laplateforme.io>
*
* Example usage:
*  
*   1-|> // 
*    -|>
*
*/

"use strict"; // <- ECMAScript 5 strict mode syntax
// ^^^^^^^^^ This keeps us on our toes, as it forces us to use all pre-defined variables, among other things 😅


// Select some elments from the DOM
const registerFormEl = document.getElementById("registerForm"); // <- register form element
const loginFormEl = document.getElementById("loginForm"); // <- login form element
const formInputEls = document.querySelectorAll("form input");
const gotoLoginBtnEl = document.querySelector("button.goto-login");
const gotoHomeBtnEl = document.querySelector("button.goto-home");
const gotoBooksBtnEl = document.querySelector("button.goto-books");
const bookFormEl = document.getElementById("bookForm");



// Define showError and showSuccess functions

/**
 * Displays an error message
 * NOTE: This method unhides the `<div class="error status-message">` element
 *
 * @param { String } message - the error message to display
 */
let showError = (message) => {
  // get the error element
  const errorEl = document.querySelector('.error.status-message');
  // get the message element as `msgEl`
  const msgEl = errorEl.querySelector('p.message');

  // Update the text content of `msgEl`
  msgEl.textContent = message;
   
  // show or unhide `successEl`
  errorEl.hidden = false;
};


/**
 * Displays a success message
 * NOTE: This method unhides the `<div class="success status-message">` element 
 *
 * @param { String } message - the success message to display
 */
let showSuccess = (message) => {
  // get the success element
  const successEl = document.querySelector('.success.status-message');
  // get the message element as `msgEl`
  const msgEl = successEl.querySelector('p.message');

  // Update the text content of `msgEl`
  msgEl.textContent = message;

  // show or unhide `successEl`
  successEl.hidden = false;
};



/**
 * Hides the error message
 */
let hideError = (el) => {
  // get the error status message element as `errorMsgEl`
  const errorMsgEl = el ?? document.querySelector('.error.status-message');

  // hide it by setting the `hidden` property to TRUE !
  errorMsgEl.hidden = true;
}


/**
 * Hides the success message
 */
let hideSuccess = (el) => {
  // get the success status message element as `successMsgEl`
  const successMsgEl = el ?? document.querySelector('.success.status-message');

  // hide it by setting the `hidden` property to TRUE !
  successMsgEl.hidden = true;
}









// Defining some event handlers ...



/**
 * Handler that is called whenever the `<form id="registerForm">` is submitted
 *
 * @param { SubmitEvent } event - The submit event object
 */
let handleRegisterFormSubmit = async (event) => {
  // Prevent the default form submission behavior
  event.preventDefault();
  
  // get the form element as `formEl`
  const formEl = event.currentTarget;

  // create a form data with `formEl` as `formData`
  const formData = new FormData(formEl);

  // get the password and confirmPassword from `formData`
  let password = formData.get("password");
  let confirmPassword = formData.get("confirmPassword");

  // TODO: Validate each form field before submitting the form



  // If the password and confirmPassword are not the same...
  if (password !== confirmPassword) {
    // hide any error
    hideError();
    // ...show error message
    showError("Passwords do not match");

    // ...and return early
    return;
  }

  // Define our url
  let url = 'register';

  // Create a new request object
  let request = new Request(url, {method: 'POST', body: formData});

  // Send the request and 'await' a response #LOL ;)
  let response = await fetch(request);
  let responseData = await response.json(); // <- get the JSON representation of the `response` as `responseData`
   
  // DEBUG [4dbsmaster]: tell me about it ;)
  console.log(responseData);

  // If the request was a success (i.e. user has been registered)...
  if (responseData.success) {
    // hide any error
    hideError();

    // ...show a success message
    showSuccess(responseData.message);

    // reset the form element
    formEl.reset();

    // hide the form element
    formEl.hidden = true;

    // show the goto login button
    gotoLoginBtnEl.hidden = false;

  }else { // <- failed to register user...
    // hide any success
    hideSuccess();
    // ...show an error message
    showError(responseData.message);
  }

  
   

  // DEBUG [4dbsmaster]: tell me about it ;)
  console.log(`\x1b[33m[handleRegisterFormSubmit]: formEl => \x1b[0m`, formEl);
};





/**
 * Handler that is called whenever the `<form id="loginForm">` is submitted
 *
 * @param { SubmitEvent } event - The submit event object
 */
let handleLoginFormSubmit = async (event) => {
  // Prevent the default form submission behavior
  event.preventDefault();
  
  // get the form element as `formEl`
  const formEl = event.currentTarget;

  // create a form data with `formEl` as `formData`
  const formData = new FormData(formEl);


  // TODO: Validate each form field before submitting the form
  

  // Define our url
  let url = 'login';

  // Create a new request object
  let request = new Request(url, {method: 'POST', body: formData});

  // Send the request and 'await' a response #LOL ;)
  let response = await fetch(request);
  let responseData = await response.json(); // <- get the JSON representation of the `response` as `responseData`
   
  // DEBUG [4dbsmaster]: tell me about it ;)
  console.log(responseData);
  
  // If the request was a success (i.e. user was connected successfully)...
  if (responseData.success) {
    // hide any error
    hideError();

    // ...show a success message
    showSuccess(responseData.message);

    // reset the form element
    formEl.reset();

    // hide the form element
    formEl.hidden = true;

    // show the go to home button
    gotoHomeBtnEl.hidden = false;

  }else { // <- failed to register user...
    // hide any success
    hideSuccess();
    // ...show an error message
    showError(responseData.message);
  }

  
   

  // DEBUG [4dbsmaster]: tell me about it ;)
  console.log(`\x1b[33m[handleRegisterFormSubmit]: formEl => \x1b[0m`, formEl);
};






/**
 * Handler that is called whenever the `<form id="bookForm">` is submitted
 *
 * @param { SubmitEvent } event - The submit event object
 */
let handleBookFormSubmit = async (event) => {
  // Prevent the default form submission behavior
  event.preventDefault();
  
  // get the form element as `formEl`
  const formEl = event.currentTarget;

  // create a form data with `formEl` as `formData`
  const formData = new FormData(formEl);


  // TODO: Validate each form field before submitting the form
  

  // Define our url
  let url = 'books/write';

  // Create a new request object
  let request = new Request(url, {method: 'POST', body: formData});

  // Send the request and 'await' a response #LOL ;)
  let response = await fetch(request);
  let responseData = await response.json(); // <- get the JSON representation of the `response` as `responseData`
   
  // DEBUG [4dbsmaster]: tell me about it ;)
  console.log(responseData);
  
  // If the request was a success (i.e. user was connected successfully)...
  if (responseData.success) {
    // hide any error
    hideError();

    // ...show a success message
    showSuccess(responseData.message);

    // reset the form element
    formEl.reset();

    // hide the form element
    formEl.hidden = true;

    // show the go to home button
    gotoHomeBtnEl.hidden = false;

    // show the go to books button
    gotoBooksBtnEl.hidden = false;

  }else { // <- failed to register user...
    // hide any success
    hideSuccess();
    // ...show an error message
    showError(responseData.message);
  }

  
   

  // DEBUG [4dbsmaster]: tell me about it ;)
  console.log(`\x1b[33m[handleRegisterFormSubmit]: formEl => \x1b[0m`, formEl);
};








// Attaching event listeners to elements in the DOM...


// If there's a `registerFormEl` element...
if (registerFormEl) {
  // ...add a submit event listener to it
  registerFormEl.addEventListener("submit", handleRegisterFormSubmit);
}

// If there's a `loginFormEl` element...
if (loginFormEl) {
  // ...add a submit event listener to it
  loginFormEl.addEventListener("submit", handleLoginFormSubmit);
}


// If there's a `bookForm` element...
if (bookFormEl) {
  // ..add a submit event listerner to it ;)
  bookFormEl.addEventListener("submit", handleBookFormSubmit);
}

// If there's a `gotoLoginBtnEl` element...
if (gotoLoginBtnEl) {
  // ...add a click event listener to it that redirects to the login page
  gotoLoginBtnEl.addEventListener("click", () => location.href = 'login');
}


// If there's a `gotoHomeBtnEl` element...
if (gotoHomeBtnEl) {
  // ...add a click event listener to it that redirects to the home page
  gotoHomeBtnEl.addEventListener("click", () => location.href = '');
}

  /*
// If there's a `gotoBooksBtnEl` element...
if (gotoBooksBtnEl) {
  // ...add a click event listener to it that redirects to the home page
  gotoBooksBtnEl.addEventListener("click", () => location.href = 'books');
}
*/


// For all the form input element...
for (let formInputEl of formInputEls) {
  // ...add a `change` event listener
  formInputEl.addEventListener('change', (event) => { 
    // hide both success and/or errors
    hideSuccess();
    hideError();
  });
}




/* ====== ASYNC FUNCTIONS ====== */


/**
 * A function that gets all the users from our server, 
 * using a predefined `super-week` route
 *
 * @returns { Promise<Array<User>> } - An array of users
 */
let getUsers = () => {
  return new Promise(async (resolve, reject) => {
    // define our url
    let url = 'users';
    // create a new request object
    // The 'raw/json' header is used to tell the server that we want the response as a JSON object
    let request = new Request(url, {method: 'GET', headers: {'Response-Type': 'raw/json'}});
    // fetch the request and 'await' a response
    let response = await fetch(request);
    // get the JSON representation of the `response` as `responseData`
    let responseData = await response.json();

    // DEBUG [4dbsmaster]: tell me about it ;)
    // console.log(responseData);

    // If the request was a success...
    if (responseData.success) {
      // resolve the promise with the users
      resolve(responseData.users);

    }else { // <- failed to get users...
      // reject the promise with the error message
      reject(responseData.message);
    }
  });
}


/**
 * A function that gets all the books from our server, 
 * using a predefined `super-week` route
 *
 * @returns { Promise<Array<Book>> } - An array of books
 */
let getBooks = () => {
  return new Promise(async (resolve, reject) => {
    // define our url
    let url = 'books';
    // create a new request object
    // The 'raw/json' header is used to tell the server that we want the response as a JSON object
    let request = new Request(url, {method: 'GET', headers: {'Response-Type': 'raw/json'}});
    // fetch the request and 'await' a response
    let response = await fetch(request);
    // get the JSON representation of the `response` as `responseData`
    let responseData = await response.json();

    // DEBUG [4dbsmaster]: tell me about it ;)
    // console.log(responseData);

    // If the request was a success...
    if (responseData.success) {
      // resolve the promise with the books
      resolve(responseData.books);

    }else { // <- failed to get books...
      // reject the promise with the error message
      reject(responseData.message);
    }
  });
}



/**
 * A function that gets a specific user from our server, 
 * using a predefined `super-week` route
 *
 * @param { Number } userId - The id of the user to get
 * @returns { Promise<Array<Book>> } - An array of books
 */
let getUser = (userId) => {
  return new Promise(async (resolve, reject) => {
    // define our url
    let url = 'users/' + userId;
    // create a new request object
    // The 'raw/json' header is used to tell the server that we want the response as a JSON object
    let request = new Request(url, {method: 'GET', headers: {'Response-Type': 'raw/json'}});
    // fetch the request and 'await' a response
    let response = await fetch(request);
    // get the JSON representation of the `response` as `responseData`
    let responseData = await response.json();

    // DEBUG [4dbsmaster]: tell me about it ;)
    console.log(responseData);

    // If the request was a success...
    if (responseData.success) {
      // resolve the promise with the user
      resolve(responseData.user);

    }else { // <- failed to get the user...
      // reject the promise with the error message
      reject(responseData.message);
    }
  });
}



/**
 * A function that gets a specific book from our server, 
 * using a predefined `super-week` route
 *
 * @param { Number } bookId - The id of the book to get
 * @returns { Promise<Array<Book>> } - An array of books
 */
let getBook = (bookId) => {
  return new Promise(async (resolve, reject) => {
    // define our url
    let url = 'books/' + bookId;
    // create a new request object
    // The 'raw/json' header is used to tell the server that we want the response as a JSON object
    let request = new Request(url, {method: 'GET', headers: {'Response-Type': 'raw/json'}});
    // fetch the request and 'await' a response
    let response = await fetch(request);
    // get the JSON representation of the `response` as `responseData`
    let responseData = await response.json();

    // DEBUG [4dbsmaster]: tell me about it ;)
    // console.log(responseData);

    // If the request was a success...
    if (responseData.success) {
      // resolve the promise with the books
      resolve(responseData.book);

    }else { // <- failed to get the book...
      // reject the promise with the error message
      reject(responseData.message);
    }
  });
}



/* == END OF ASYNC FUNCTIONS == */


/**
 * Hides the `<ul class="result">` element of the given action element
 * NOTE: This function will remove all its children.
 *
 * @param { String } action - The result action (e.g. 'users', 'books', 'user' & 'book')
 * @param { HTMLButtonElement } buttonEl - The button element that triggered this function
 */
let hideResultOf = (action, buttonEl) => {
  // get the `resultEl` element
  let resultEl = document.querySelector(`.async-action.${action} .result`);

  // remove all the children of `usersResultEl`, 
  // well technically, we're just replacing it with '...' #LOL
  resultEl.innerHTML = '...';

  // remove the `completed` attribute from the button element
  buttonEl.removeAttribute('completed');

  // rename the `<span>` in button element (e.g: 'show users')
  buttonEl.querySelector('span').innerHTML = `show ${action} ${['user', 'book'].includes(action) ? 'info' : ''}`;

};


/**
 * Returns the HTML template for the given `user`
 *
 * @param { Object } user - The user object
 *
 * @returns { String } - The HTML template for the given `user`
 */
let getUserTemplate = (user) => {
  return `
    <!-- User -->
    <li class="user" data-id="${user.id}" title="Token: ${user.token}">
      <a href="users/${user.id}" target="_blank" class="link" title="Click to open the user in a new tab">

        <!-- Initials -->
        <span class="initials"><b>${user.first_name[0]}${user.last_name[0]}</b></span>

        <!-- Info -->
        <div class="info">
          <h3 class="fullname">${user.first_name} ${user.last_name}</h3>
          <p class="email">${user.email}</p>
        </div>
        
        <!-- Id -->
        <span class="id">id: <em>${user.id}</em></span>

      </a>
     </li>
  `;
};



/**
 * Returns the HTML template for the given `book`
 *
 * @param { Object } book - The book object
 *
 * @returns { String } - The HTML template for the given `book`
 */
let getBookTemplate = (book) => {
  return `
    <!-- Book -->
    <li class="book" data-id="${book.id}">
      <a href="books/${book.id}" target="_blank" class="link" title="Click to open the book in a new tab">

        <!-- Icon -->
        <span class="material-icons icon">book</span>

        <!-- Info -->
        <div class="info">
          <h3 class="title" title="${book.title}">${book.title}</h3>
          <p class="content" title="${book.content}">${(book.content.length > 100) ? book.content.substr(0, 100) + '...' : book.content}</p>
        </div>
        
        <!-- Id -->
        <span class="id">id: <em>${book.id}</em></span>

      </a>
     </li>
  `;
};

/**
 * Shows the given users in the `<ul class="result">` element of the `users` action element
 *
 * @param { Array<User> } users - An array of users
 * @param { HTMLButtonElement } buttonEl - The button element that triggered this function
 */
let showUsers = (users, buttonEl) => {
  // get the next sibling of the button element, which is the `<ul class="result">` element as `resultEl`
  let resultEl = buttonEl.nextElementSibling;

  // DEBUG [4dbsmaster]: tell me about it ;) 
  console.log(`\x1b[33m[showUsers]: users => \x1b[0m`, users);

  // add the `completed` attribute to the button element
  buttonEl.setAttribute('completed', '');

  // rename the `<span>` in button element accordingly
  buttonEl.querySelector('span').innerHTML = `hide users`;
  
  // remove the ellipsis from the `resultEl`
  resultEl.innerHTML = '';

  // loop through the users
  for (let user of users) {
    // ..get the user template as `userTemplate`
    let userTemplate = getUserTemplate(user);
    // insert the `userTemplate` into the `resultEl`
    resultEl.insertAdjacentHTML('beforeend', userTemplate);
  }

};


/**
 * Shows the given books in the `<ul class="result">` element of the `books` action element
 *
 * @param { Array<Book> } books - An array of books
 * @param { HTMLButtonElement } buttonEl - The button element that triggered this function
 */
let showBooks = (books, buttonEl) => {
  // get the next sibling of the button element, which is the `<ul class="result">` element as `resultEl`
  let resultEl = buttonEl.nextElementSibling;

  // DEBUG [4dbsmaster]: tell me about it ;) 
  console.log(`\x1b[33m[showBooks]: books => \x1b[0m`, books);

  // add the `completed` attribute to the button element
  buttonEl.setAttribute('completed', '');

  // rename the `<span>` in button element accordingly
  buttonEl.querySelector('span').innerHTML = `hide books`;

  // remove the ellipsis from the `resultEl`
  resultEl.innerHTML = '';

  // loop through the books
  for (let book of books) {
    // ..get the book template as `userTemplate`
    let bookTemplate = getBookTemplate(book);
    // insert the `bookTemplate` into the `resultEl`
    resultEl.insertAdjacentHTML('beforeend', bookTemplate);
  }

};



/**
 * Shows the specific user in the `<ul class="result">` element of the `user` action element
 *
 * @param { Object<User> } user - A user object
 * @param { HTMLButtonElement } buttonEl - The button element that triggered this function
 */
let showUser = (user, buttonEl) => {
  // get the next sibling of the button element, which is the `<ul class="result">` element as `resultEl`
  let resultEl = buttonEl.nextElementSibling;

  // DEBUG [4dbsmaster]: tell me about it ;) 
  console.log(`\x1b[33m[showUsers]: user => \x1b[0m`, user);

  // add the `completed` attribute to the button element
  buttonEl.setAttribute('completed', '');

  // rename the `<span>` in button element accordingly
  buttonEl.querySelector('span').innerHTML = `hide user info`;


  // remove the ellipsis from the `resultEl`
  resultEl.innerHTML = '';

  // get the user template as `userTemplate`
  let userTemplate = getUserTemplate(user);
  // insert the `userTemplate` into the `resultEl`
  resultEl.insertAdjacentHTML('beforeend', userTemplate);
   
};


/**
 * Shows the specific book in the `<ul class="result">` element of the `book` action element
 *
 * @param { Object<Book> } book - A book object
 * @param { HTMLButtonElement } buttonEl - The button element that triggered this function
 */
let showBook = (book, buttonEl) => {
  // get the next sibling of the button element, which is the `<ul class="result">` element as `resultEl`
  let resultEl = buttonEl.nextElementSibling;

  // DEBUG [4dbsmaster]: tell me about it ;) 
  console.log(`\x1b[33m[showBook]: book => \x1b[0m`, book);

  // add the `completed` attribute to the button element
  buttonEl.setAttribute('completed', '');

  // rename the `<span>` in button element accordingly
  buttonEl.querySelector('span').innerHTML = `hide book info`;
  
  // remove the ellipsis from the `resultEl`
  resultEl.innerHTML = '';
  
  // get the book template as `bookTemplate`
  let bookTemplate = getBookTemplate(book);
  // insert the `bookTemplate` into the `resultEl`
  resultEl.insertAdjacentHTML('beforeend', bookTemplate);

};




// Define a function that handles the click event on the `asyncButtonEls`
let handleAsyncButtonClick = async (event) => {
  // get the button element as `buttonEl`
  let buttonEl = event.currentTarget;

  let inputEl = buttonEl.previousElementSibling;

  // get the button's `data-action` attribute as `action`
  let action = buttonEl.dataset.action;

  // get the button's `completed` attribute as `isComplete`
  let isCompleted = buttonEl.hasAttribute('completed');

  // Hide the users result, if the action was completed
  if (isCompleted) { hideResultOf(action, buttonEl); return }


  // switch on the `action`...
  switch (action) {
    case 'users':
      // get all the users from the server
      let users = await getUsers();
      // show the users result
      showUsers(users, buttonEl);
      break;

    case 'books':
      // get all the books from the server
      let books = await getBooks();
      // show the books result
      showBooks(books, buttonEl);
      break;

    case 'user':
      // get the value of the input element as `userId`
      let userId = inputEl.value;
      
      // DEBUG [4dbsmaster]: tell me about it ;)
      console.log(`\x1b[33m[handleAsyncButtonClick]: userId => \x1b[0m`, userId);

      // If there's a user id...
      if (typeof userId !== 'undefined' && userId !== '') {

        // Initialize the user object variable
        // let user = {};

        try {
          // ...get the specific user from the server using the `userId`
          let user = await getUser(userId);

          // show the user
          showUser(user, buttonEl);

        } catch (error) {
          // DEBUG [4dbsmaster]: tell me about it ;)
          console.log(`\x1b[33m[handleAsyncButtonClick]: error => \x1b[0m`, error);
        }

      }

      break;

    case 'book':
      // get the value of the input element as `bookId`
      let bookId = inputEl.value;

      // If there's a book id...
      if (typeof bookId !== 'undefined' && bookId !== '') {
        // ...get the specific book from the server using the `bookId`
        let book = await getBook(bookId);
        // show the book 
        showBook(book, buttonEl);
      }

      break;

    default:
      // do nothing 4 now ;)
  }


};



// Get all async-button elements as `asyncButtonEls`
let asyncButtonEls = document.querySelectorAll('.async-button');

// Loop through all the `asyncButtonEls`...
for (let asyncButtonEl of asyncButtonEls) {
  // ...add a click event listener to each of them
  asyncButtonEl.addEventListener('click', handleAsyncButtonClick);
}
