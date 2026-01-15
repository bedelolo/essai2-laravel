<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Congés & Permissions</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero {
            min-height: 80vh;
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
       <a class="navbar-brand fw-bold" href="{{ url('/') }}">
    Gestion Congés
</a>

        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

{{-- HERO SECTION --}}
<section class="hero">
    <div class="container text-center">
        <h1 class="display-5 fw-bold mb-3">
            Application de Gestion des Congés & Permissions
        </h1>

        <p class="lead mb-4">
            Digitalisez la soumission, la validation et le suivi des demandes
            de congé et de permission au sein de votre organisation.
        </p>

        @guest
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">
                Se connecter
            </a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                Créer un compte
            </a>
        @endguest

        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-success btn-lg">
                Accéder au tableau de bord
            </a>
        @endauth
    </div>
</section>

{{-- FEATURES --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="row text-center">
            <h2 class="mb-5 fw-bold">Fonctionnalités principales</h2>

            <div class="col-md-3">
                <h5>📄 Demandes</h5>
                <p>Soumission simple des congés et permissions.</p>
            </div>

            <div class="col-md-3">
                <h5>✅ Validation</h5>
                <p>Workflow clair de validation ou de refus.</p>
            </div>

            <div class="col-md-3">
                <h5>📊 Suivi</h5>
                <p>Suivi en temps réel de l’état des demandes.</p>
            </div>

            <div class="col-md-3">
                <h5>🕒 Historique</h5>
                <p>Traçabilité complète des actions effectuées.</p>
            </div>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="bg-dark text-white py-4">
    <div class="container text-center">
        <p class="mb-1">
            © {{ date('Y') }} — Application de Gestion des Congés
        </p>
        <small>Développé avec Laravel</small>
    </div>
</footer>

</body>
</html>
