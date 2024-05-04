<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 50px;
        }
        .card {
            margin: 0 auto;
            float: none;
            margin-bottom: 10px;
            width: 400px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <button id="loginBtn" class="btn btn-link">Login</button> |
                        <button id="registerBtn" class="btn btn-link">Register</button> |
                        <button id="adminBtn" class="btn btn-link">Admin</button>
                    </div>
                    <div class="card-body" id="loginForm">
                        <form method="POST" action="/login">
                            @csrf
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                    <div class="card-body" id="registerForm" style="display: none;">
                        <form method="POST" action="/register">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required minlength="3" maxlength="40">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Email (contoh: nama@gmail.com)" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="Password (6-12)" required minlength="6" maxlength="12">
                            </div>
                            <div class="form-group">
                                <input type="text" name="handphone" class="form-control" placeholder="Nomor Handphone (contoh: 0812xxxxxxxx)" required pattern="08[0-9]{9,}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </form>
                    </div>
                    <div class="card-body" id="adminForm" style="display: none;">
                        <form method="POST" action="{{ route('admin') }}">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="admin_id" class="form-control" placeholder="ID Admin" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="Password (6-12)" required minlength="6" maxlength="12">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login as Admin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginBtn').addEventListener('click', function() {
            document.getElementById('loginForm').style.display = 'block';
            document.getElementById('registerForm').style.display = 'none';
            document.getElementById('adminForm').style.display = 'none';
        });

        document.getElementById('registerBtn').addEventListener('click', function() {
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('registerForm').style.display = 'block';
            document.getElementById('adminForm').style.display = 'none';
        });

        document.getElementById('adminBtn').addEventListener('click', function() {
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('registerForm').style.display = 'none';
            document.getElementById('adminForm').style.display = 'block';
        });
    </script>
</body>
</html>
