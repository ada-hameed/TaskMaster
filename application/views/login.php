<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>

    <!-- Bootstrap + Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <style>
    body {
        background: #f0f2f5;
        font-family: 'Inter', sans-serif;
    }

    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px;
    }

    .login-box {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 420px;
    }

    .login-title {
        text-align: center;
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }

    .form-control:focus {
        box-shadow: none;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15);
    }


    .btn-primary {
        width: 100%;
        border-radius: 8px;
        padding: 10px;
        font-weight: 600;
    }

    .form-text {
        text-align: center;
        margin-top: 15px;
    }

    .form-text a {
        color: #007bff;
        text-decoration: none;
    }

    @media (max-width: 576px) {
        .login-box {
            padding: 20px;
        }

        .login-title {
            font-size: 1.5rem;
        }

        .btn-primary {
            padding: 8px;
            font-size: 0.95rem;
        }

        .form-text {
            font-size: 0.9rem;
        }
    }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="login-box">
            <h2 class="login-title">User Login</h2>

            <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
            <?php endif; ?>

            <form id="loginForm" action="<?= base_url('login/authenticate') ?>" method="post">
                <!-- Email -->
                <div class="mb-3 input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="Email address">
                </div>

                <!-- Password -->
                <div class="mb-4 input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>

                <!-- Normal Login -->
                <button type="submit" class="btn btn-primary w-100 mb-3">
                    Login
                </button>
                <!-- Google & Truecaller in same row -->
                <div class="row">
                    <div class="col-6">
                        <a href="<?= base_url('login/google_login') ?>" class="btn btn-danger w-100">
                            <i class="fab fa-google"></i> Google
                        </a>
                    </div>
                    <div class="col-6">
                        <a  href="<?= base_url('login/truecaller_login') ?>"
                            class="btn btn-info w-100">
                            <i class="fas fa-phone"></i> Truecaller
                        </a>
                    </div>


                </div>
            </form>

            <div class="form-text">
                Don't have an account? <a href="<?= base_url('register') ?>">Register</a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="<?= base_url('assets/js/login.js') ?>"></script>

    <script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000"
    };

    <?php if ($this->session->flashdata('toastr_success')): ?>
    toastr.success("<?= $this->session->flashdata('toastr_success') ?>");
    <?php endif; ?>
    </script>





</body>

</html>