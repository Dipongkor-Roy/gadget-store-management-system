document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".form-login");

    form.addEventListener("submit", function (event) {
        const email = document.querySelector('input[name="admin_email"]').value.trim();
        const password = document.querySelector('input[name="admin_pass"]').value.trim();

        // Email validation
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            alert("Please enter a valid email address.");
            event.preventDefault(); // Prevent form submission
            return;
        }

        // Password validation
        if (password.length < 4) {
            alert("Password must be at least 4 characters long.");
            event.preventDefault();
            return;
        }
    });
});
