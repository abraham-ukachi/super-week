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
const createAccountButtonEl = document.getElementById("createAccountButton"); // <- create account button element
const registerFormEl = document.getElementById("registerForm"); // <- register form element



// Defining some event handlers ...


/**
 * Handler that is called whenever the create account button is clicked
 *
 * @param { ClickEvent } event - The click event object
 */
let handleCreateAccountButtonClick = function (event) {

  // DEBUG [4dbsmaster]: tell me about it ;)
  console.log(`\x1b[33m[handleCreateAccountButtonClick]: event => \x1b[0m`, event);
};



/**
 * Handler that is called whenever the `<form id="registerForm">` is submitted
 *
 * @param { ClickEvent } event - The click event object
 */
let handleRegisterFormSubmit = function (event) {

  // DEBUG [4dbsmaster]: tell me about it ;)
  console.log(`\x1b[33m[handleRegisterFormSubmit]: event => \x1b[0m`, event);
};
















// Attaching event listeners to elements in the DOM...

// If there's a `createAccountButtonEl` element... 
if (createAccountButtonEl) {
  // ...add a click event listener to it
  createAccountButtonEl.addEventListener("click", handleCreateAccountButtonClick);
}

// If there's a `registerFormEl` element...
if (registerFormEl) {
  // ...add a submit event listener to it
  registerFormEl.addEventListener("submit", handleRegisterFormSubmit);
}
