<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReparaYa - Gestión de Averías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; }

        .navbar-top {
            background: #1a252f;
            border-bottom: 3px solid #e74c3c;
            padding: .6rem 2rem;
        }
        .navbar-top .brand { color: #fff; font-weight: 700; font-size: 1.3rem; text-decoration: none; }
        .navbar-top .brand span { color: #e74c3c; }
        .navbar-top .nav-links a {
            color: rgba(255,255,255,.8);
            text-decoration: none;
            margin-left: 1rem;
            font-size: .9rem;
        }
        .navbar-top .nav-links a:hover { color: #fff; }

        .hero {
            background: linear-gradient(135deg, #1a252f 0%, #2c3e50 100%);
            color: white;
            padding: 90px 0 80px;
            text-align: center;
        }
        .hero h1 { font-size: 2.8rem; font-weight: 700; margin-bottom: .5rem; }
        .hero h1 span { color: #e74c3c; }
        .hero p { font-size: 1.15rem; color: rgba(255,255,255,.75); max-width: 520px; margin: 0 auto 2rem; }
        .btn-hero-primary {
            background: #e74c3c;
            border: none;
            color: white;
            padding: .7rem 2rem;
            border-radius: 6px;
            font-size: 1rem;
            text-decoration: none;
            margin-right: .75rem;
        }
        .btn-hero-primary:hover { background: #c0392b; color: white; }
        .btn-hero-outline {
            border: 2px solid rgba(255,255,255,.5);
            color: white;
            padding: .7rem 2rem;
            border-radius: 6px;
            font-size: 1rem;
            text-decoration: none;
        }
        .btn-hero-outline:hover { border-color: white; color: white; }

        .features { padding: 70px 0; background: #f4f6f9; }
        .features h2 { text-align: center; font-weight: 700; color: #1a252f; margin-bottom: 2.5rem; font-size: 1.8rem; }
        .feature-card {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,.07);
            height: 100%;
        }
        .feature-card .icon { font-size: 2.2rem; color: #e74c3c; margin-bottom: 1rem; }
        .feature-card h5 { font-weight: 600; color: #1a252f; margin-bottom: .5rem; }
        .feature-card p { color: #6c757d; font-size: .9rem; margin: 0; }

        .profiles { padding: 70px 0; }
        .profiles h2 { text-align: center; font-weight: 700; color: #1a252f; margin-bottom: 2.5rem; font-size: 1.8rem; }
        .profile-card {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            transition: border-color .2s;
        }
        .profile-card:hover { border-color: #e74c3c; }
        .profile-card .icon { font-size: 2.5rem; color: #1a252f; margin-bottom: 1rem; }
        .profile-card h5 { font-weight: 600; margin-bottom: .5rem; }
        .profile-card p { color: #6c757d; font-size: .88rem; margin: 0; }

        .cta-section { background: #e74c3c; color: white; padding: 60px 0; text-align: center; }
        .cta-section h2 { font-weight: 700; font-size: 2rem; margin-bottom: .75rem; }
        .cta-section p { color: rgba(255,255,255,.85); margin-bottom: 1.5rem; }
        .btn-cta {
            background: white;
            color: #e74c3c;
            font-weight: 600;
            padding: .7rem 2rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 1rem;
        }
        .btn-cta:hover { background: #f8f9fa; color: #e74c3c; }

        footer {
            background: #1a252f;
            color: rgba(255,255,255,.5);
            text-align: center;
            padding: 1.5rem;
            font-size: .85rem;
        }
    </style>
</head>
<body>

{{-- NAV --}}
<nav class="navbar-top d-flex justify-content-between align-items-center">
    <a href="{{ route('home') }}" class="brand">Repara<span>Ya</span></a>
    <div class="nav-links">
        <a href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-1"></i>Iniciar sesión</a>
        <a href="{{ route('register') }}"><i class="bi bi-person-plus me-1"></i>Crear cuenta</a>
    </div>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="container">
        <h1>Repara<span>Ya</span></h1>
        <p>Gestión de averías domésticas de forma rápida y eficiente. Fontanería, electricidad, carpintería y más.</p>
        <a href="{{ route('login') }}" class="btn-hero-primary">Iniciar sesión</a>
        <a href="{{ route('register') }}" class="btn-hero-outline">Crear cuenta</a>
    </div>
</section>

{{-- FEATURES --}}
<section class="features">
    <div class="container">
        <h2>¿Qué ofrece ReparaYa?</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon"><i class="bi bi-wrench-adjustable"></i></div>
                    <h5>Solicitud de servicios</h5>
                    <p>Los clientes pueden solicitar asistencia técnica en cualquier momento, con hasta 48h de antelación para servicios estándar.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon"><i class="bi bi-calendar3"></i></div>
                    <h5>Calendario visual</h5>
                    <p>Vista mensual, semanal y diaria de todos los avisos. Los servicios urgentes y estándar se diferencian por colores.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon"><i class="bi bi-person-gear"></i></div>
                    <h5>Asignación de técnicos</h5>
                    <p>El administrador asigna técnicos especializados a cada aviso de forma sencilla desde el panel de control.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon"><i class="bi bi-list-check"></i></div>
                    <h5>Historial de avisos</h5>
                    <p>Consulta todos los servicios solicitados, pasados y futuros. Cancela cuando lo necesites con antelación suficiente.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon"><i class="bi bi-lightning-charge"></i></div>
                    <h5>Servicio urgente 24h</h5>
                    <p>Para emergencias, el servicio urgente garantiza atención en menos de 24 horas con técnicos disponibles.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon"><i class="bi bi-shield-check"></i></div>
                    <h5>Acceso seguro</h5>
                    <p>Sistema de registro y login con roles por usuario. Cada usuario accede solo a su información.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- PERFILES --}}
<section class="profiles">
    <div class="container">
        <h2>Perfiles de usuario</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="profile-card">
                    <div class="icon"><i class="bi bi-person-circle"></i></div>
                    <h5>Cliente</h5>
                    <p>Solicita servicios, consulta el historial de tus avisos y gestiona tu perfil.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="profile-card">
                    <div class="icon"><i class="bi bi-tools"></i></div>
                    <h5>Técnico</h5>
                    <p>Consulta los avisos asignados, actualiza el estado y gestiona tu agenda de trabajo.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="profile-card">
                    <div class="icon"><i class="bi bi-speedometer2"></i></div>
                    <h5>Administrador</h5>
                    <p>Gestión completa: avisos, técnicos, tipos de servicio, calendario y liquidaciones.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="container">
        <h2>Empieza ahora</h2>
        <p>Crea tu cuenta y gestiona tus averías de forma sencilla.</p>
        <a href="{{ route('register') }}" class="btn-cta">Crear cuenta gratis</a>
    </div>
</section>

<footer>
    ReparaYa &copy; {{ date('Y') }}
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
