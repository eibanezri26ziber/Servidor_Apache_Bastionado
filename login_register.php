<?php

$usuario_valido = "admin@gmail.com";
$password_valida = "123";

$error = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_action'])) {
    $email = trim($_POST['email'] ?? '');
    $password =$_POST['password'] ?? '';

    // Condicional if/else para validar usuario y contraseña
    if ($email ===$usuario_valido && $password ===$password_valida) {
        // Redireccionar a otra página si el login es exitoso
        header('Location: index_registrado.html');
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso y Registro</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Fade animation for smooth view switches */
        .form-fade-in {
            animation: fadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4 text-slate-800">

    <!-- Floating Toast Notification System -->
    <div id="toast-container" class="fixed top-5 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <!-- Main Form Card Container -->
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden transition-all duration-300">
        
        <!-- Header Branding -->
        <div class="p-8 pb-4 text-center">
            <div class="w-12 h-12 bg-indigo-600 rounded-xl mx-auto flex items-center justify-center text-white mb-3 shadow-md shadow-indigo-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457-.39-2.823-1.07-4" />
                </svg>
            </div>
            <h1 id="card-title" class="text-2xl font-bold text-slate-900 tracking-tight">¡Hola de nuevo!</h1>
            <p id="card-subtitle" class="text-sm text-slate-500 mt-1">Ingresa a tu cuenta para continuar</p>
        </div>

        <!-- Tab Toggle Buttons -->
        <div class="px-8 mb-6">
            <div class="bg-slate-100 p-1 rounded-xl flex items-center">
                <button 
                    id="tab-login" 
                    type="button"
                    onclick="switchTab('login')" 
                    class="flex-1 py-2 text-sm font-semibold rounded-lg text-slate-800 bg-white shadow-sm transition-all duration-200 focus:outline-none">
                    Iniciar Sesión
                </button>
                <button 
                    id="tab-register" 
                    type="button"
                    onclick="switchTab('register')" 
                    class="flex-1 py-2 text-sm font-medium rounded-lg text-slate-500 hover:text-slate-800 transition-all duration-200 focus:outline-none">
                    Registrarse
                </button>
            </div>
        </div>

        <div class="px-8 pb-8">
            <!-- LOGIN FORM -->
            <form id="login-form" method="POST" action="" onsubmit="handleLoginSubmit(event)" class="form-fade-in space-y-4" novalidate>
                <input type="hidden" name="login_action" value="1">
                <div>
                    <label for="login-email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Correo o Usuario</label>
                    <input 
                        type="text" 
                        id="login-email" 
                        name="email"
                        placeholder="nombre@ejemplo.com"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all placeholder:text-slate-400"
                    >
                    <p id="login-email-error" class="hidden text-xs text-rose-500 mt-1.5 flex items-center gap-1"></p>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="login-password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">Contraseña</label>
                    </div>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="login-password" 
                            name="password"
                            placeholder="••••••••"
                            class="w-full px-4 py-2.5 pr-10 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all placeholder:text-slate-400"
                        >
                        <button 
                            type="button" 
                            onclick="togglePasswordVisibility('login-password', 'login-pwd-icon')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors p-1"
                            title="Ocultar/Mostrar contraseña">
                            <svg id="login-pwd-icon" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <p id="login-password-error" class="hidden text-xs text-rose-500 mt-1.5 flex items-center gap-1"></p>
                </div>

                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-semibold text-sm rounded-xl shadow-md shadow-indigo-200 hover:shadow-lg hover:shadow-indigo-300/50 transition-all duration-200 flex items-center justify-center gap-2">
                        <span>Iniciar Sesión</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>

            <!-- REGISTER FORM -->
            <form id="register-form" onsubmit="handleRegisterSubmit(event)" class="hidden space-y-4" novalidate>
                <div>
                    <label for="reg-name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Nombre Completo</label>
                    <input 
                        type="text" 
                        id="reg-name" 
                        placeholder="Ana García"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all placeholder:text-slate-400"
                    >
                    <p id="reg-name-error" class="hidden text-xs text-rose-500 mt-1.5 flex items-center gap-1"></p>
                </div>

                <div>
                    <label for="reg-email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Correo Electrónico</label>
                    <input 
                        type="email" 
                        id="reg-email" 
                        placeholder="ana@ejemplo.com"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all placeholder:text-slate-400"
                    >
                    <p id="reg-email-error" class="hidden text-xs text-rose-500 mt-1.5 flex items-center gap-1"></p>
                </div>

                <div>
                    <label for="reg-password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Contraseña</label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="reg-password" 
                            placeholder="Mínimo 6 caracteres"
                            class="w-full px-4 py-2.5 pr-10 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all placeholder:text-slate-400"
                        >
                        <button 
                            type="button" 
                            onclick="togglePasswordVisibility('reg-password', 'reg-pwd-icon')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors p-1"
                            title="Ocultar/Mostrar contraseña">
                            <svg id="reg-pwd-icon" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <p id="reg-password-error" class="hidden text-xs text-rose-500 mt-1.5 flex items-center gap-1"></p>
                </div>

                <div>
                    <label for="reg-confirm-password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Confirmar Contraseña</label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="reg-confirm-password" 
                            placeholder="Repite tu contraseña"
                            class="w-full px-4 py-2.5 pr-10 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all placeholder:text-slate-400"
                        >
                        <button 
                            type="button" 
                            onclick="togglePasswordVisibility('reg-confirm-password', 'reg-confirm-pwd-icon')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors p-1"
                            title="Ocultar/Mostrar contraseña">
                            <svg id="reg-confirm-pwd-icon" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <p id="reg-confirm-error" class="hidden text-xs text-rose-500 mt-1.5 flex items-center gap-1"></p>
                </div>

                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-semibold text-sm rounded-xl shadow-md shadow-indigo-200 hover:shadow-lg hover:shadow-indigo-300/50 transition-all duration-200 flex items-center justify-center gap-2">
                        <span>Crear Cuenta</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript Logic -->
    <script>
        function switchTab(tab) {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const tabLoginBtn = document.getElementById('tab-login');
            const tabRegisterBtn = document.getElementById('tab-register');
            const cardTitle = document.getElementById('card-title');
            const cardSubtitle = document.getElementById('card-subtitle');

            clearErrors();

            if (tab === 'login') {
                loginForm.classList.remove('hidden');
                loginForm.classList.add('form-fade-in');
                registerForm.classList.add('hidden');
                registerForm.classList.remove('form-fade-in');

                tabLoginBtn.className = "flex-1 py-2 text-sm font-semibold rounded-lg text-slate-800 bg-white shadow-sm transition-all duration-200 focus:outline-none";
                tabRegisterBtn.className = "flex-1 py-2 text-sm font-medium rounded-lg text-slate-500 hover:text-slate-800 transition-all duration-200 focus:outline-none";

                cardTitle.textContent = "¡Hola de nuevo!";
                cardSubtitle.textContent = "Ingresa a tu cuenta para continuar";
            } else if (tab === 'register') {
                registerForm.classList.remove('hidden');
                registerForm.classList.add('form-fade-in');
                loginForm.classList.add('hidden');
                loginForm.classList.remove('form-fade-in');

                tabRegisterBtn.className = "flex-1 py-2 text-sm font-semibold rounded-lg text-slate-800 bg-white shadow-sm transition-all duration-200 focus:outline-none";
                tabLoginBtn.className = "flex-1 py-2 text-sm font-medium rounded-lg text-slate-500 hover:text-slate-800 transition-all duration-200 focus:outline-none";

                cardTitle.textContent = "Crea tu cuenta";
                cardSubtitle.textContent = "Completa tus datos para registrarte";
            }
        }

        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a8.959 8.959 0 013.682-.783c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21f-3-3m-3-3l-3-3m-2-2l-3-3M3 3l18 18" />';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
            }
        }

        function showError(fieldId, errorId, message) {
            if (fieldId) {
                const field = document.getElementById(fieldId);
                if (field) field.classList.add('border-rose-400', 'bg-rose-50/30');
            }
            if (errorId) {
                const errorElem = document.getElementById(errorId);
                if (errorElem) {
                    errorElem.textContent = message;
                    errorElem.classList.remove('hidden');
                }
            }
        }

        function clearErrors() {
            const errorElements = document.querySelectorAll('[id$="-error"]');
            errorElements.forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });

            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.classList.remove('border-rose-400', 'bg-rose-50/30');
            });
        }

        function validateEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        function handleLoginSubmit(event) {
            event.preventDefault();
            clearErrors();

            const email = document.getElementById('login-email').value.trim();
            const password = document.getElementById('login-password').value;
            let isValid = true;

            if (!email) {
                showError('login-email', 'login-email-error', 'Ingresa tu correo o usuario');
                isValid = false;
            }

            if (!password) {
                showError('login-password', 'login-password-error', 'Ingresa tu contraseña');
                isValid = false;
            }

            if (isValid) {
                // Si la validación en JS pasa, se envía el formulario al PHP
                event.target.submit();
            }
        }

        function handleRegisterSubmit(event) {
            event.preventDefault();
            clearErrors();

            const name = document.getElementById('reg-name').value.trim();
            const email = document.getElementById('reg-email').value.trim();
            const password = document.getElementById('reg-password').value;
            const confirmPassword = document.getElementById('reg-confirm-password').value;
            let isValid = true;

            if (!name) {
                showError('reg-name', 'reg-name-error', 'Por favor ingresa tu nombre');
                isValid = false;
            }

            if (!email) {
                showError('reg-email', 'reg-email-error', 'Por favor ingresa tu correo');
                isValid = false;
            } else if (!validateEmail(email)) {
                showError('reg-email', 'reg-email-error', 'Ingresa un correo electrónico válido');
                isValid = false;
            }

            if (!password) {
                showError('reg-password', 'reg-password-error', 'Ingresa una contraseña');
                isValid = false;
            } else if (password.length < 6) {
                showError('reg-password', 'reg-password-error', 'La contraseña debe tener al menos 6 caracteres');
                isValid = false;
            }

            if (!confirmPassword) {
                showError('reg-confirm-password', 'reg-confirm-error', 'Confirma tu contraseña');
                isValid = false;
            } else if (password !== confirmPassword) {
                showError('reg-confirm-password', 'reg-confirm-error', 'Las contraseñas no coinciden');
                isValid = false;
            }

            if (isValid) {
                showToast('¡Cuenta creada con éxito!', 'success');
                document.getElementById('register-form').reset();
                setTimeout(() => switchTab('login'), 1200);
            }
        }

        function showToast(message, type = 'info') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            const isSuccess = type === 'success';
            const isError = type === 'error';
            
            let bgColor = 'bg-slate-800';
            if (isSuccess) bgColor = 'bg-emerald-600';
            if (isError) bgColor = 'bg-rose-600';

            toast.className = `${bgColor} text-white text-sm px-4 py-3 rounded-xl shadow-lg flex items-center gap-2 transition-all duration-300 transform -translate-y-2 opacity-0 pointer-events-auto`;
            
            const iconPath = isSuccess 
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />'
                : (isError 
                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />' 
                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />');

            toast.innerHTML = `<svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">${iconPath}</svg><span>${message}</span>`;

            container.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.remove('-translate-y-2', 'opacity-0');
            });

            setTimeout(() => {
                toast.classList.add('opacity-0', '-translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>

    <!-- Si PHP detecta un error de credenciales, lanza la notificación Toast roja -->
    <?php if (!empty($error)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showToast('<?php echo addslashes($error); ?>', 'error');
        });
    </script>
    <?php endif; ?>
</body>
</html>