$(document).ready(function () {
  $('#registerForm').on('submit', function (e) {
    let isValid = true;

    const name = $('input[name="name"]');
    const email = $('input[name="email"]');
    const pass = $('input[name="password"]');
    const mobile = $('input[name="mobile"]');

    if (!name.val().trim()) {
      name.addClass('is-invalid');
      isValid = false;
    } else {
      name.removeClass('is-invalid');
    }

    if (!email.val().trim()) {
      email.addClass('is-invalid');
      isValid = false;
    } else {
      email.removeClass('is-invalid');
    }

    if (!pass.val().trim()) {
      pass.addClass('is-invalid');
      isValid = false;
    } else {
      pass.removeClass('is-invalid');
    }

    if (!mobile.val().trim()) {
      mobile.addClass('is-invalid');
      isValid = false;
    } else {
      mobile.removeClass('is-invalid');
    }

    if (!isValid) e.preventDefault();
  });

  $('input').on('input', function () {
    $(this).removeClass('is-invalid');
  });


});
