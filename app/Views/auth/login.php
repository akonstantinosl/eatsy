<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Eatsy</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.0.0/sweetalert2.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #1e88e5 0%, #0d47a1 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            font-family: 'Source Sans Pro', sans-serif;
        }
        
        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            border: none;
        }
        
        .card-header {
            background-color: #0d47a1;
            padding: 20px;
            border-bottom: none;
        }
        
        .card-header h1 {
            color: white;
            font-weight: 700;
            margin: 0;
            font-size: 28px;
        }
        
        .card-body {
            padding: 30px;
            background-color: white;
        }
        
        .login-box-msg {
            color: #6c757d;
            margin-bottom: 25px;
            text-align: center;
            font-size: 16px;
        }
        
        .btn-primary {
            background-color: #1976d2;
            border-color: #1976d2;
            padding: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary:hover, .btn-primary:focus {
            background-color: #0d47a1;
            border-color: #0d47a1;
            box-shadow: 0 5px 15px rgba(0, 105, 217, 0.4);
        }
        
        .input-group-text {
            background-color: #e9ecef;
            border-color: #ced4da;
        }
        
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .icheck-primary label {
            color: #6c757d;
        }
        
        .back-link {
            display: block;
            text-align: center;
            color: #1976d2;
            margin-top: 20px;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .back-link:hover {
            color: #0d47a1;
            text-decoration: none;
        }
        
        .input-group {
            margin-bottom: 20px;
        }
        
        .bg-dots {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(rgba(255, 255, 255, 0.15) 2px, transparent 2px);
            background-size: 30px 30px;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="bg-dots"></div>
    <div class="login-container">
        <div class="card">
            <div class="card-header text-center">
                <h1><b>Eatsy</b></h1>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="/login" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Username" name="username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block py-2">Sign In</button>
                </form>

                <a href="/" class="back-link">Back to Home</a>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.0.0/sweetalert2.min.js"></script>
    
    <script>
    $(document).ready(function() {
        // Error handling can be implemented here
        // Example:
        /*
        if (errorType === 'account_inactive') {
            Swal.fire({
                icon: 'error',
                title: 'Inactive Account',
                text: 'Your account is currently inactive. Please contact the administrator for activation.',
                confirmButtonColor: '#1976d2',
                confirmButtonText: 'OK',
                allowOutsideClick: false,
                scrollbarPadding: false,
                heightAuto: false,
                position: 'center'
            });
        } else if (errorType === 'invalid_credentials') {
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: 'The username or password you entered is incorrect.',
                confirmButtonColor: '#1976d2',
                confirmButtonText: 'OK',
                allowOutsideClick: false,
                scrollbarPadding: false,
                heightAuto: false,
                position: 'center'
            });
        }
        */
    });
    </script>
</body>
</html>