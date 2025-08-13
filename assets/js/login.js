$(document).ready(function () {
  
  $('#loginForm').on('submit', function (e) {
    let isValid = true;

    // Email
    const emailField = $('input[name="email"]');
    if (!emailField.val().trim()) {
      emailField.addClass('is-invalid');
      isValid = false;
    } else {
      emailField.removeClass('is-invalid');
    }

    // Password
    const passField = $('input[name="password"]');
    if (!passField.val().trim()) {
      passField.addClass('is-invalid');
      isValid = false;
    } else {
      passField.removeClass('is-invalid');
    }

    if (!isValid) e.preventDefault();
  });

  $('input').on('input', function () {
    $(this).removeClass('is-invalid');
  });
  
});
    