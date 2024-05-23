<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #ffffff;
            color: #000000;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .top-bar,
        .bottom-bar {
            background-color: rgb(160, 182, 32);
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            height: 50px;
        }

        .nav-links a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
            font-weight: 600;
        }

        .bottom-bar {
            justify-content: center;
        }

        .content-box {
            border: 1px solid #000;
            padding: 20px;
            margin: 20px auto;
            max-width: 800px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .content-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .manual-content p {
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .manual-content br {
            margin-bottom: 10px;
        }

        .commands {
            background-color: #e7e7e7;
            /* padding: 15px; */
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .commands span {
            display: block;
            margin-bottom: 10px;
        }

        footer {
            margin-top: auto;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="top-bar">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/WIL_LOGO.png') }}" class="logo" alt="WIL Logo">
        </a>

        <div class="nav-links">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>

    <div class="content-box">
        <div class="content-title">Description</div>
        <p>This project aims to develop and launch a user-friendly website that allows users to apply for a job for the
            community local sport club as a volunteer. So, volunteers can easily process their application for their
            local sport club.</p>
    </div>

    <div class="content-box">
        <div class="content-title">Manual</div>
        <div class="manual-content">
            <p><strong>Initial Setup</strong></p>
            <p>
                Open the terminal<br>
                <span class="commands">
                    Command: cd your directory<br>
                    Command: git clone https://github.com/SeorinLee/3821ICT.git<br>
                    Command: cd project name (would be WIL_project)<br>
                    Command: composer install<br>
                    Command: php artisan migrate<br>
                </span>
                Press yes for all the questions
            </p>

            <p><strong>For the 500 Server Error</strong></p>
            <p>
                Check the error<br>
                <span class="commands">
                    Command: tail -f storage/logs/laravel.log<br>
                </span>
            </p>

            <p><strong>Commands</strong></p>
            <span class="commands">
                php artisan config:clear<br>
                php artisan cache:clear<br>
                php artisan route:clear<br>
                php artisan view:clear<br>
                php artisan optimize:clear<br>
            </span>

            <p><strong>Create .env</strong></p>
            <p>
                <span class="commands">
                    Command: cp .env.example .env<br>
                </span>
            </p>

            <p><strong>Create App Key</strong></p>
            <p>
                <span class="commands">
                    Command: php artisan key:generate<br>
                </span>
            </p>

            <p><strong>Double Check Migration</strong></p>
            <span class="commands">
                Commands:<br>
                php artisan migrate:reset<br>
                php artisan migrate<br>
            </span>

            <p><strong>For Running the Dev Server</strong></p>
            <p>
                Install laravel-vite-plugin<br>
                <span class="commands">
                    Command: sudo npm install --save-dev laravel-vite-plugin<br>
                </span>
                Try<br>
                <span class="commands">
                    Command: npm run dev<br>
                </span>
            </p>

            <p><strong>Running the Server</strong></p>
            <p>
                <span class="commands">
                    Command: php artisan serve<br>
                </span>
            </p>

            <p>* If commands are not working, add “sudo” in front of command 😃</p>
        </div>
    </div>

    <footer class="bottom-bar">
        <span>&copy; 2024 Your Company</span>
    </footer>
</body>

</html>