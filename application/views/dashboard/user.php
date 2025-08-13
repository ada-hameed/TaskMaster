<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">My Profile</h3>
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <thead class="thead-light">
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <div style="display: flex; align-items: center; gap: 10px;">
                    <?php
                    $default_img = 'assets/img/user2-160x160.jpg';
                    $img_path = isset($profile->profile_image) && trim($profile->profile_image) !== ''
                      ? $profile->profile_image
                      : $default_img;
                    $final_img = (strpos($img_path, 'http') === 0) ? $img_path : base_url($img_path);
                    ?>
                    <img
                      src="<?= $final_img ?>"
                      onerror="this.onerror=null; this.src='<?= base_url($default_img) ?>';"
                      alt="Photo"
                      width="30"
                      height="30"
                      style="object-fit: cover; border-radius: 50%;">
                    <span><?= $profile->name ?></span>
                  </div>

                </td>

                <td><?= $profile->email ?></td>
                <td><?= $profile->contact_number ?></td>
                <td>
                  <i class="fas fa-edit text-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal" style="cursor: pointer;"></i>
                </td>
              </tr>
            </tbody>
          </table>

          <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <form id="editProfileForm"
                  action="<?= base_url('dashboard/update_profile') ?>"
                  method="post"
                  enctype="multipart/form-data"
                  data-success="<?= $this->session->flashdata('success') ?>"
                  data-error="<?= $this->session->flashdata('error') ?>">

                  <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">
                    <?php if (!empty($error)): ?>
                      <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <input type="hidden" name="id" value="<?= $profile->id ?>">

                    <div class="mb-3">
                      <label class="form-label">Name</label>
                      <input type="text" name="name" class="form-control" value="<?= $profile->name ?>">
                      <div class="invalid-feedback">Name is required.</div>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Email</label>
                      <input type="email" name="email" class="form-control" value="<?= $profile->email ?>">
                      <div class="invalid-feedback">Email is required.</div>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Phone</label>
                      <input type="text" name="contact_number" class="form-control" pattern="[0-9]{10}" maxlength="10"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'');" value="<?= $profile->contact_number ?>">
                      <div class="invalid-feedback">Phone number is required.</div>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">New Password</label>
                      <input type="password" name="password" class="form-control">
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Profile Image (optional)</label><br>
                      <input type="file" name="profile_image" class="form-control mt-2">
                      <?php
                      $default_image = 'assets/img/user2-160x160.jpg';
                      $img_path = !empty($profile->profile_image) ? $profile->profile_image : $default_image;
                      $final_img = (strpos($img_path, 'http') === 0) ? $img_path : base_url($img_path);
                      ?>
                      <img src="<?= $final_img ?>" alt="Profile" width="70" class="mb-2 mt-2 rounded"
                        onerror="this.onerror=null; this.src='<?= base_url($default_image) ?>';">


                      <!-- <small class="form-text text-muted">Max 2MB. Allowed: JPG, JPEG, PNG.</small> -->
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm">Update</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                  </div>

                </form>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('editProfileModal');
    const form = document.getElementById('editProfileForm');

    <?php if (!empty($error)): ?>
      const bsModal = new bootstrap.Modal(modal);
      bsModal.show();
    <?php endif; ?>

    modal.addEventListener('hidden.bs.modal', function() {
      form.reset();

      form.querySelector('input[name="name"]').value = "<?= $profile->name ?>";
      form.querySelector('input[name="email"]').value = "<?= $profile->email ?>";
      form.querySelector('input[name="contact_number"]').value = "<?= $profile->contact_number ?>";

      form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
      const alerts = modal.querySelectorAll('.alert');
      alerts.forEach(alert => alert.remove());
    });
  });

</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
  // Toast options
  toastr.options = {
    "closeButton": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "4000"
  };

  <?php if ($this->session->flashdata('toastr_success')): ?>
    toastr.success("<?= $this->session->flashdata('toastr_success') ?>");
  <?php endif; ?>
});

</script>