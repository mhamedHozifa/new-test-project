<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @php
        // #region agent log
        file_put_contents(
            base_path('debug-6456cc.log'),
            json_encode([
                'sessionId' => '6456cc',
                'runId' => 'initial',
                'hypothesisId' => 'H6',
                'location' => 'resources/views/layouts/admin.blade.php:8',
                'message' => 'Admin layout rendered with vite directive',
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
<body class="bg-slate-100 text-slate-800">
    <div class="min-h-screen lg:grid lg:grid-cols-[260px_1fr]">
        @include('layouts.partials.admin-sidebar')

        <div class="flex min-h-screen flex-col">
            @include('layouts.partials.admin-header')

            <main class="flex-1 p-4 md:p-6">
                @include('layouts.partials.admin-flash')
                @yield('content')
            </main>

            @include('layouts.partials.admin-footer')
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const styleLinks = Array.from(document.querySelectorAll('link[rel="stylesheet"]')).map((link) => link.href);
            const viteClientScript = document.querySelector('script[type="module"][src*="vite/client"]');
            const adminBtn = document.querySelector('.admin-btn');
            const adminBtnStyles = adminBtn ? window.getComputedStyle(adminBtn) : null;

            // #region agent log
            fetch('http://127.0.0.1:7667/ingest/67db9715-8ded-41a8-8622-79196ed54812',{method:'POST',headers:{'Content-Type':'application/json','X-Debug-Session-Id':'6456cc'},body:JSON.stringify({sessionId:'6456cc',runId:'initial',hypothesisId:'H1',location:'resources/views/layouts/admin.blade.php:25',message:'Stylesheet links discovered',data:{styleLinks},timestamp:Date.now()})}).catch(()=>{});
            // #endregion
            // #region agent log
            fetch('http://127.0.0.1:7667/ingest/67db9715-8ded-41a8-8622-79196ed54812',{method:'POST',headers:{'Content-Type':'application/json','X-Debug-Session-Id':'6456cc'},body:JSON.stringify({sessionId:'6456cc',runId:'initial',hypothesisId:'H2',location:'resources/views/layouts/admin.blade.php:27',message:'Vite client script presence',data:{viteClientLoaded:Boolean(viteClientScript),viteClientSrc:viteClientScript?.src??null},timestamp:Date.now()})}).catch(()=>{});
            // #endregion
            // #region agent log
            fetch('http://127.0.0.1:7667/ingest/67db9715-8ded-41a8-8622-79196ed54812',{method:'POST',headers:{'Content-Type':'application/json','X-Debug-Session-Id':'6456cc'},body:JSON.stringify({sessionId:'6456cc',runId:'initial',hypothesisId:'H3',location:'resources/views/layouts/admin.blade.php:29',message:'admin-btn computed style sample',data:{adminBtnExists:Boolean(adminBtn),backgroundColor:adminBtnStyles?.backgroundColor??null,paddingTop:adminBtnStyles?.paddingTop??null,borderRadius:adminBtnStyles?.borderRadius??null},timestamp:Date.now()})}).catch(()=>{});
            // #endregion
        });
    </script>
    @stack('scripts')
</body>
</html>