<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metinca - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="bi bi-gear-fill"></i>
                </div>
                <h1 class="brand-name">Metinca Starter App</h1>
                <p class="brand-tagline">The Starter App for metinca application web program</p>
            </div>

            <div class="alert alert-danger d-none" id="errorAlert" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <span id="errorMessage">Username atau password salah!</span>
            </div>

            <form id="loginForm" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">
                        <i class="bi bi-person-fill me-1"></i>Username atau Email
                    </label>
                    <div class="input-group">
                        <input type="text" name="email" class="form-control with-icon" id="username" placeholder="Masukkan username atau email" required>
                        <span class="input-icon">
                            <i class="bi bi-person"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock-fill me-1"></i>Password
                    </label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control with-icon" id="password" placeholder="Masukkan password" required>
                        <span class="input-icon password-toggle" onclick="togglePassword()">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </span>
                    </div>
                </div>

                <div class="remember-forgot">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            Ingat saya
                        </label>
                    </div>
                    <a href="#" class="forgot-link">Lupa password?</a>
                </div>

                <button type="submit" class="btn-login" id="submitBtn">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                </button>
            </form>

            <div class="signup-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>
            
            <div class="signup-link mt-2">
                atau <a href="/home">Kembali ke Homepage</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
    <script>
        // Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
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

        // Handle Login Form Submit
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const submitBtn = document.getElementById('submitBtn');
            const originalBtnText = submitBtn.innerHTML;
            
            // Ambil data form
            const formData = new FormData(form);
            
            // Loading State
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
            
            // Menggunakan Axios langsung untuk menghindari error jika App object tidak ada
            axios.post(form.action, formData)
                .then(response => {
                    // Berhasil
                    Swal.fire({
                        title: 'Login Berhasil',
                        text: 'Selamat datang kembali!',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '{{ route("dashboard") }}';
                    });
                })
                .catch(error => {
                    // Gagal
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;

                    let message = 'Terjadi kesalahan pada server.';
                    
                    if (error.response) {
                        if (error.response.status === 422) {
                            // Error validasi (ValidationException)
                            message = error.response.data.message || 'Username atau password salah.';
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
            
            // Shake effect
            errorAlert.classList.add('shake');
            setTimeout(() => errorAlert.classList.remove('shake'), 500);

            // Auto hide
            setTimeout(() => {
                errorAlert.classList.add('d-none');
            }, 5000);
        }

        // Hide error alert when user starts typing
        ['username', 'password'].forEach(id => {
            document.getElementById(id).addEventListener('input', function() {
                document.getElementById('errorAlert').classList.add('d-none');
            });
        });
    </script>
</body>
</html>