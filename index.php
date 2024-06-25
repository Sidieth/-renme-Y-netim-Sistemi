<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f7f9fc;
        }
        .login-container {
            margin-top: 100px;
        }
        .login-card {
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #2c3e50;
            color: white;
        }
        .login-title {
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: 700;
            color: white;
        }
        .form-control {
            border-radius: 50px;
            background-color: #34495e;
            color: white;
            border: none;
        }
        .form-control::placeholder {
            color: #bdc3c7;
        }
        .btn-primary {
            border-radius: 50px;
            padding: 10px 20px;
            background-color: #1abc9c;
            border: none;
        }
        .btn-primary:hover {
            background-color: #16a085;
        }
        .text-links a {
            color: #ecf0f1;
        }
        .text-links a:hover {
            color: #bdc3c7;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-card">
                    <h2 class="text-center login-title">Giriş Formu</h2>
                    <form action="login.php" method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Kullancı Adı" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Şifre" required>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="role" name="role" required>
                                <option value="" disabled selected>Kullanıcı Türünü Seçin</option>
                                <option value="admin">Danaişma</option>
                                <option value="teacher">Öğretmen</option>
                                <option value="student">Öğrenci</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Giriş</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
