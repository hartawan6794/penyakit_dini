<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="<?= base_url('asset/img/logo_puskes.png') ?>">
    <title>Login</title>
    <link rel="stylesheet" href="<?= base_url('asset/css/adminlte.min.css') ?>">
    <style>
        body {
            background: url('<?= base_url('asset/img/bg.jpg'); ?>') no-repeat center center fixed;
            background-size: cover;
            height: 100%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 10px;
        }

        .site-login {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .site-login img {
            max-width: 100px;
        }

        .form-group .form-control {
            padding: 10px 20px;
        }

        .btn-block {
            padding: 10px 20px;
        }

        .btn-secondary {
            padding: 10px 20px;
            background-color: #6c757d;
            border-color: #6c757d;
        }
    </style>
    <script src="<?= base_url('asset/js/jquery-3.6.0.min.js') ?>"></script>
</head>

<body>
    <div class="site-login">
        <div class="card shadow-sm p-4">
            <div class="text-center mb-4">
                <img src="<?= base_url('asset/img/logo_puskes.png'); ?>" alt="Logo" class="mb-3">
                <h1 class="h6 mb-3 font-weight-normal">SISTEM INFORMASI TENTANG PENYAKIT PADA ANAK USIA DINI DI PUSKESMAS GEDUNG KARYA JITU</h1>
                <div id="alert-container"></div>
                <?php if (isset($message)) : ?>
                    <div class="alert alert-success">
                        <?= $message ?>
                    </div>
                <?php endif; ?>
                <p class="text-muted">Masukan username dan password untuk masuk:</p>
            </div>

            <form id="login-form">
                <div class="form-group mb-3">
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" autofocus>
                </div>

                <div class="form-group mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                </div>

                <div class="form-group mb-3 form-check">
                    <input type="checkbox" name="rememberMe" id="rememberMe" class="form-check-input">
                    <label class="form-check-label">Remember Me</label>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-block" id="login-button">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {

        $('#login-button').on('click', function() {
            var username = $('#username').val();
            var password = $('#password').val();

            $.ajax({
                url: '<?= base_url('auth/login') ?>',
                type: 'POST',
                data: {
                    username: username,
                    password: password,
                },
                success: function(response) {
                    if (response.status == 'success') {
                        window.location.href = '<?= base_url('home') ?>';
                    } else {
                        var alertHtml = '<div class="alert alert-danger">';
                        if (typeof response.messages === 'string') {
                            alertHtml += response.messages;
                        } else {
                            $.each(response.messages, function(key, value) {
                                alertHtml += '<p>' + value + '</p>';
                            });
                        }
                        alertHtml += '</div>';
                        $('#alert-container').html(alertHtml);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX Error: ' + status + error);
                }
            });
        });
    });
</script>


</html>