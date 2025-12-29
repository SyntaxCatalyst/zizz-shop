<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Under Maintenance - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 0.5; }
            100% { transform: scale(1.3); opacity: 0; }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        .animate-pulse-ring {
            animation: pulse-ring 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body class="bg-gray-900 text-white font-sans antialiased overflow-hidden selection:bg-purple-500 selection:text-white">

    <div class="min-h-screen flex flex-col items-center justify-center relative px-4">
        
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-purple-600/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-blue-600/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <!-- Main Content -->
        <div class="relative z-10 max-w-2xl w-full text-center">
            
            <!-- Illustration -->
            <div class="mb-12 relative inline-block animate-float">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-blue-500 rounded-full blur-2xl opacity-20 animate-pulse-ring"></div>
                <svg class="w-48 h-48 mx-auto text-gray-200 relative z-10" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z" class="fill-gray-800 stroke-purple-500" stroke-width="0.5"/>
                    <circle cx="12" cy="12" r="3" class="fill-blue-500 animate-pulse"/>
                    <path d="M12 8v4l3 3" stroke="white" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>

            <h1 class="text-5xl md:text-6xl font-black mb-6 tracking-tight">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400">System Upgrade</span>
                <br>In Progress
            </h1>

            <p class="text-xl text-gray-400 mb-10 leading-relaxed max-w-lg mx-auto">
                We are currently performing scheduled maintenance to improve our services. We'll be back online shortly.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <div class="px-6 py-3 rounded-full bg-white/5 border border-white/10 backdrop-blur-sm flex items-center gap-3">
                     <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-500"></span>
                    </span>
                    <span class="text-sm font-medium text-gray-300">Status: Maintenance Mode</span>
                </div>
                
                <button onclick="window.location.reload()" class="px-6 py-3 rounded-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white font-bold transition-all hover:scale-105 shadow-lg shadow-purple-500/25 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Check Status
                </button>
            </div>

            <div class="mt-16 text-sm text-gray-500">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>

        </div>
    </div>

    <script>
        // Auto refresh every 30 seconds to check if site is back
        setInterval(() => {
            fetch(window.location.href, { method: 'HEAD' })
                .then(response => {
                    if (response.status === 200) {
                        window.location.reload();
                    }
                })
                .catch(() => {
                    // Still down or network error, do nothing
                    console.log('Still in maintenance...');
                });
        }, 30000);
    </script>
</body>
</html>
