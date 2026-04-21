<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @php
        // #region agent log
        file_put_contents(
            base_path('debug-6456cc.log'),
            json_encode([
                'sessionId' => '6456cc',
                'runId' => 'initial',
                'hypothesisId' => 'H7',
                'location' => 'resources/views/admin/login.blade.php:8',
                'message' => 'Login layout rendered with vite directive',
                'data' => [
                    'hotFileExists' => file_exists(public_path('hot')),
                    'manifestExists' => file_exists(public_path('build/manifest.json')),
                    'requestPath' => request()->path(),
                ],
                'timestamp' => round(microtime(true) * 1000),
            ]) . PHP_EOL,
            FILE_APPEND
        );
        // #endregion
    @endphp
</head>
<body class="flex min-h-screen items-center justify-center bg-slate-100 p-4">
    <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-sm">
        <h1 class="mb-6 text-center text-xl font-semibold">Admin Login</h1>
        @if ($errors->any())
            <div class="mb-4 rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
            @csrf

            <div class="admin-form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="admin-input" required autofocus>
            </div>

            <div class="admin-form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="admin-input" required>
            </div>

            <button type="submit" class="admin-btn admin-btn-primary w-full justify-center">Login</button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const styleLinks = Array.from(document.querySelectorAll('link[rel="stylesheet"]')).map((link) => link.href);
            const loginForm = document.querySelector('form');
            const loginFormStyles = loginForm ? window.getComputedStyle(loginForm) : null;

            // #region agent log
            fetch('http://127.0.0.1:7667/ingest/67db9715-8ded-41a8-8622-79196ed54812',{method:'POST',headers:{'Content-Type':'application/json','X-Debug-Session-Id':'6456cc'},body:JSON.stringify({sessionId:'6456cc',runId:'initial',hypothesisId:'H4',location:'resources/views/admin/login.blade.php:41',message:'Login page stylesheet links discovered',data:{styleLinks},timestamp:Date.now()})}).catch(()=>{});
            // #endregion
            // #region agent log
            fetch('http://127.0.0.1:7667/ingest/67db9715-8ded-41a8-8622-79196ed54812',{method:'POST',headers:{'Content-Type':'application/json','X-Debug-Session-Id':'6456cc'},body:JSON.stringify({sessionId:'6456cc',runId:'initial',hypothesisId:'H5',location:'resources/views/admin/login.blade.php:43',message:'Login form computed style sample',data:{loginFormExists:Boolean(loginForm),display:loginFormStyles?.display??null,rowGap:loginFormStyles?.rowGap??null},timestamp:Date.now()})}).catch(()=>{});
            // #endregion
        });
    </script>
</body>
</html>