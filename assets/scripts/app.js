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



// For all the form input element...
for (let formInputEl of formInputEls) {
  // ...add a `change` event listener
  formInputEl.addEventListener('change', (event) => { 
    // hide both success and/or errors
    hideSuccess();
    hideError();
  });
}
