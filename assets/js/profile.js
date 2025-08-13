$(document).ready(function () {
  // Flash messages from HTML data attributes
  const success = $('#editProfileForm').data('success');
  const error = $('#editProfileForm').data('error');

  if (success) toastr.success(success);
  if (error) toastr.error(error);

  // Simple form validation
  $('#editProfileForm').on('submit', function (e) {
    let isValid = true;
    const name = $('input[name="name"]').val().trim();
    const email = $('input[name="email"]').val().trim();
    const contact = $('input[name="contact_number"]').val().trim();

    $(this).find('input').removeClass('is-invalid');

    if (!name) {
      $('input[name="name"]').addClass('is-invalid');
      isValid = false;
    }
    if (!email) {
      $('input[name="email"]').addClass('is-invalid');
      isValid = false;
    }
    if (!contact || contact.length !== 10) {
      $('input[name="contact_number"]').addClass('is-invalid');
      isValid = false;
    }

    if (!isValid) e.preventDefault();
  });
});

