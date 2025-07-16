<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom style.css -->
    <link rel="stylesheet" href="../style.css">
    <style>
        .theme-green { color: #43a047 !important; }
        .btn-theme-green { background-color: #43a047 !important; border-color: #43a047 !important; color: #fff !important; }
        .btn-theme-green:hover { background-color: #388e3c !important; border-color: #388e3c !important; }
        a.theme-green-link { color: #43a047 !important; }
        a.theme-green-link:hover { color: #2e7031 !important; }
    </style>
</head>
<body style="min-height:100vh;">
    <div class="d-flex justify-content-center align-items-center" style="min-height:100vh;">
        <div class="container" style="max-width: 400px; background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 2em; margin:0;">
            <h2 class="text-center mb-4 theme-green"><i class="fa fa-sign-in-alt me-2"></i>Login</h2>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3 text-end">
                    <a href="#" class="theme-green-link">Forgot Password?</a>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-theme-green" name="login">Login</button>
                </div>
                <div class="text-center">
                    <span>Don't have an account? <a href="user_registration.php" class="theme-green-link">Register</a></span>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>