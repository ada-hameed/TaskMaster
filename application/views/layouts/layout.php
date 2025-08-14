<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
        crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css">

    <!-- Local CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

    <!-- DataTables CSS -->
    <link rel="stylesheet"
        href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet"
        href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet"
        href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css">
    
<title>Dashboard</title>

</head>

<body>
    <div class="wrapper d-flex">
        <!-- Sidebar -->
        <aside id="sidebar">
            <div>
                <!-- Sidebar Profile Logo Section -->
                <div class="sidebar-logo ">
                    <div class="user-panel d-flex align-items-center p-3 border-bottom">
                        <?php
                        $default_img = 'assets/img/user2-160x160.jpg';
                        $img_path = isset($profile->profile_image) && trim($profile->profile_image) !== '' ? $profile->profile_image : $default_img;
                        $final_img = (strpos($img_path, 'http') === 0) ? $img_path : base_url($img_path);
                        ?>
                        <div class="image">
                            <img src="<?= $final_img ?>"
                                onerror="this.onerror=null; this.src='<?= base_url($default_img) ?>';"
                                alt="User"
                                class="img-circle"
                                style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                        </div>
                        <div class="info ms-2 flex-grow-1">
                            <span class="d-block text-white text-truncate">
                                <?= htmlentities($profile->name) ?>
                            </span>
                        </div>
                    </div>


                </div>
                <!-- Sidebar Navigation -->
                <ul class="sidebar-nav">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed"
                            data-bs-toggle="collapse"
                            data-bs-target="#dashboard"
                            aria-expanded="false" aria-controls="dashboard">
                            <i class="fa-solid fa-sliders pe-2"></i>
                            Dashboard
                        </a>
                        <ul id="dashboard"
                            class="sidebar-dropdown list-unstyled collapse"
                            data-bs-parent="#sidebar">

                            <li class="sidebar-item">
                                <a href="<?= base_url('dashboard/tasks') ?>" class="sidebar-link">
                                    <i class="fa-solid fa-tasks pe-2"></i>
                                    Task Management
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a href="<?= base_url('dashboard/user') ?>" class="sidebar-link">
                                    <i class="fa-solid fa-user pe-2"></i>
                                    My Profile
                                </a>
                            </li>

                        </ul>
                    </li>
                </ul>

            </div>
        </aside>

        <!-- Main Content -->
        <div class="main d-flex flex-column w-100">
            <nav class="navbar navbar-expand px-3 border-bottom dashboard-navbar">
                <button class="btn" type="button" data-bs-theme="dark"
                    style="outline: none !important; box-shadow: none !important; border: none !important;">
                    <i class="fas fa-bars"></i>
                </button>



                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="<?= base_url('dashboard/logout') ?>" id="logoutBtn" class="btn btn-sm btn-light">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </nav>

            <main class="content px-3 py-2 flex-grow-1">
                <?php $this->load->view($content); ?>
            </main>

            <footer class="text-center py-3 border-top"
                style="background: #f8f9fa;">
                <div class="container">
                    <span class="text-muted">© 2025 Your Company. All rights
                        reserved.</span>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Local JS (Put Before Bootstrap) -->
    <script src="<?= base_url('assets/js/script.js') ?>"></script>
    <script src="<?= base_url('assets/js/profile.js') ?>"></script>
    <script src="<?= base_url('assets/js/register.js') ?>"></script>
    <script src="<?= base_url('assets/js/login.js') ?>"></script>

    <!-- Bootstrap Bundle JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous">
    </script>
    <!-- DataTables JS -->
    <script
        src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script
        src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script
        src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script
        src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script
        src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script
        src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

    <!-- For Excel export -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- For PDF export -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.datatables.net/rowreorder/1.4.1/js/dataTables.rowReorder.min.js"></script>

    <script>
        document.getElementById('logoutBtn').addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to logout?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, logout',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url('dashboard/logout') ?>";
                }
            });
        });
    </script>
</body>

</html>