// Get the login and register buttons by their IDs
const registerButton = document.getElementById('register-button');

// Get the form dialogs and overlay elements by their IDs
const registerForm = document.getElementById('register-form');
const overlay = document.createElement('div');
overlay.className = 'overlay';

// Function to show the login form as a dialog
function showLoginForm() {
  loginForm.style.display = 'block';
  document.body.appendChild(overlay);
}

// Function to show the registration form as a dialog
function showRegisterForm() {
  registerForm.style.display = 'block';
  document.body.appendChild(overlay);
}

// Function to hide the forms and overlay
function hideForms() {
  loginForm.style.display = 'none';
  registerForm.style.display = 'none';
  document.body.removeChild(overlay);
}

// Add click event listeners to the login and register buttons
registerButton.addEventListener('click', showRegisterForm);

// Add click event listener to the overlay to hide forms when clicked
overlay.addEventListener('click', hideForms);
