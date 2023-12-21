// Remove search-term from URL when page is reloaded
if (window.location.href.includes("?search-term=")) {
    history.replaceState({}, document.title, window.location.href.split("?")[0]);
}

// Add event listener to search icon if it exists
const searchIcon = document.querySelector(".search-icon");

if (searchIcon) {
    searchIcon.addEventListener("click", () => {
        const searchForm = document.getElementById("search-form");
        searchForm.submit();
    });
} else {
    console.warn("Element with class .search-icon not found.");
}

// Assume you have a login form with inputs for username and password
const loginForm = document.getElementById("login-form");

loginForm.addEventListener("submit", async (e) => {
  e.preventDefault();

  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;

  // Perform a login request to your server (not shown here)
  const response = await loginToServer(username, password);

  if (response.success) {
    // Save user session data (e.g., session token or user ID) on the client-side
    localStorage.setItem("sessionToken", response.sessionToken);

    // Redirect to the previous page or a default page
    const previousPage = sessionStorage.getItem("previousPage") || "/";
    window.location.href = previousPage;
  } else {
    alert("Login failed. Please try again.");
  }
});
