function togglePassword() {
    var passwordInput = document.getElementById("password");
    var confirmPasswordInput = document.getElementById("confirmPassword");
    var toggleIcon = document.getElementById("toggle-icon");

    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      confirmPasswordInput.type = "text";
      toggleIcon.innerHTML = '<i class="fas fa-eye"></i>';

    } else {
      passwordInput.type = "password";
      confirmPasswordInput.type = "password";
      toggleIcon.innerHTML = '<i class="fas fa-eye-slash"></i>';

    }
  }

 