<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metinca - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css">
    <style>
        .register-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="login-card" style="width: 100%; max-width: 500px;">
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="bi bi-person-plus-fill"></i>
                </div>
                <h1 class="brand-name">Metinca Starter App</h1>
                <p class="brand-tagline">Daftar akun baru untuk mengakses aplikasi</p>
            </div>

            <div class="alert alert-danger d-none" id="errorAlert" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <span id="errorMessage">Terjadi kesalahan saat registrasi!</span>
            </div>

            <form id="registerForm" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="fullname" class="form-label">
                        <i class="bi bi-person-fill me-1"></i>Nama Lengkap
                    </label>
                    <div class="input-group">
                        <input type="text" name="name" class="form-control with-icon" id="fullname" placeholder="Masukkan nama lengkap" required>
                        <span class="input-icon">
                            <i class="bi bi-person"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="register-email" class="form-label">
                        <i class="bi bi-envelope-fill me-1"></i>Email
                    </label>
                    <div class="input-group">
                        <input type="email" name="email" class="form-control with-icon" id="register-email" placeholder="Masukkan email" required>
                        <span class="input-icon">
                            <i class="bi bi-envelope"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="register-password" class="form-label">
                        <i class="bi bi-lock-fill me-1"></i>Password
                    </label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control with-icon" id="register-password" placeholder="Masukkan password" required>
                        <span class="input-icon password-toggle" onclick="togglePassword('register-password', 'toggleIconRegister')">
                            <i class="bi bi-eye" id="toggleIconRegister"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="register-confirm-password" class="form-label">
                        <i class="bi bi-lock-fill me-1"></i>Konfirmasi Password
                    </label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" class="form-control with-icon" id="register-confirm-password" placeholder="Konfirmasi password" required>
                        <span class="input-icon password-toggle" onclick="togglePassword('register-confirm-password', 'toggleIconConfirm')">
                            <i class="bi bi-eye" id="toggleIconConfirm"></i>
                        </span>
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="terms" required>
                    <label class="form-check-label" for="terms">
                        Saya setuju dengan <a href="#" class="text-decoration-none">Syarat & Ketentuan</a>
                    </label>
                </div>

                <button type="submit" class="btn-login" id="submitBtn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="bi bi-person-plus-fill me-2"></i>Daftar Akun
                </button>
            </form>

            <div class="signup-link">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
    
    <script>
        // Universal Toggle Password
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }

        // Handle Register Form Submit
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const password = document.getElementById('register-password').value;
            const passwordConfirm = document.getElementById('register-confirm-password').value;

            // Validasi Password Match di Client Side
            if (password !== passwordConfirm) {
                showError('Password konfirmasi tidak cocok!');
                return;
            }

            const form = this;
            const submitBtn = document.getElementById('submitBtn');
            const originalBtnText = submitBtn.innerHTML;
            const formData = new FormData(form);

            // Loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mendaftarkan...';

            // Menggunakan Axios agar konsisten dengan Login
            axios.post(form.action, formData)
                .then(response => {
                    Swal.fire({
                        title: 'Registrasi Berhasil',
                        text: 'Akun Anda telah terdaftar. Silahkan login!',
                        icon: 'success',
                        confirmButtonText: 'Login'
                    }).then(() => {
                        window.location.href = '{{ route("login") }}';
                    });
                })
                .catch(error => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;

                    let message = 'Terjadi kesalahan saat registrasi.';
                    
                    if (error.response) {
                         if (error.response.status === 422) {
                            // Ambil pesan error pertama dari validasi Laravel
                            const errors = error.response.data.errors;
                            message = Object.values(errors)[0][0]; 
                        } else if (error.response.data && error.response.data.message) {
                            message = error.response.data.message;
                        }
                    }
                    showError(message);
                });
        });

        // Show Error Message
        function showError(message) {
            const errorAlert = document.getElementById('errorAlert');
            const errorMessage = document.getElementById('errorMessage');
            
            errorMessage.textContent = message;
            errorAlert.classList.remove('d-none');
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                errorAlert.classList.add('d-none');
            }, 5000);
        }

        // Hide error alert when user starts typing
        ['fullname', 'register-email', 'register-password', 'register-confirm-password'].forEach(id => {
            document.getElementById(id).addEventListener('input', function() {
                document.getElementById('errorAlert').classList.add('d-none');
            });
        });
    </script>
</body>
</html>