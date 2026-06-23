<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify Identity — PIPE</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
    @livewireStyles
    <style>
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fade-up 0.5s ease-out forwards; opacity: 0; }
        .animate-fade-up-d1 { animation-delay: 0.1s; }
        .animate-fade-up-d2 { animation-delay: 0.2s; }
    </style>
</head>
<body class="h-full font-sans antialiased text-gray-600 bg-gradient-to-br from-gray-50 via-white to-gray-100 overflow-x-hidden">

    {{-- NAVBAR --}}
    <header class="fixed inset-x-0 top-0 z-50 border-b border-gray-200/80 bg-white/80 backdrop-blur-xl shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 py-3.5">
            <a href="/" class="flex items-center gap-2.5 group shrink-0">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-blue-700 shadow-sm">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5l8.5 5.5-8.5 5.5L3.5 13 12 7.5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 2.5l8.5 5.5-8.5 5.5L3.5 8 12 2.5z" />
                    </svg>
                </div>
                <span class="text-lg font-bold tracking-tight text-gray-900">PIPE</span>
            </a>
        </div>
    </header>

    <div class="relative min-h-screen flex items-center justify-center pt-20 pb-12 px-4 sm:px-6">
        <div class="pointer-events-none absolute inset-0 -z-10">
            <div class="absolute -right-40 -top-40 h-[500px] w-[500px] rounded-full bg-gradient-to-br from-blue-100/20 to-blue-200/10 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 h-[400px] w-[400px] rounded-full bg-gradient-to-tr from-gray-100/60 to-transparent blur-3xl"></div>
        </div>

        <div class="w-full max-w-md">
            <div class="animate-fade-up text-center mb-8">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 shadow-md">
                    <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Two-Factor Authentication</h1>
                <p class="mt-1.5 text-sm text-gray-500">Enter the 6-digit code sent to your registered device. <strong class="text-gray-700">Pokhara Research Centre</strong></p>
            </div>

            <div class="animate-fade-up animate-fade-up-d1 rounded-xl border border-gray-200/60 bg-white p-8 shadow-xl shadow-gray-200/50">
                @if (session('pipe_2fa_dispatched'))
                    @php $otp = session('pipe_2fa_otp'); @endphp
                    <div class="mb-5 rounded-lg border border-blue-200/60 bg-gradient-to-r from-blue-50 to-blue-100/50 p-4 text-sm text-blue-700 shadow-sm">
                        <div class="flex items-start gap-2.5">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <div>
                                <p class="font-medium">Development mode — OTP Code:</p>
                                <p class="mt-1 font-mono text-2xl tracking-[0.3em] text-blue-800">{{ $otp }}</p>
                                <p class="mt-1 text-xs text-blue-600">Auto-filled below for convenience.</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('status'))
                    <div class="mb-5 rounded-lg border border-green-200/60 bg-gradient-to-r from-green-50 to-green-100/50 p-3 text-sm text-green-700 shadow-sm">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-red-200/60 bg-gradient-to-r from-red-50 to-red-100/50 p-3 text-sm text-red-600 shadow-sm">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('two-factor.verify') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="otp" class="block text-sm font-medium text-gray-700 mb-1.5">Authentication Code</label>
                        <input id="otp" name="otp" type="text" inputmode="numeric" pattern="[0-9]{6}" maxlength="6"
                            autocomplete="one-time-code" required autofocus
                            class="block w-full text-center text-2xl font-mono tracking-[0.5em] rounded-lg border-0 bg-white px-4 py-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 placeholder:text-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-xl transition"
                            placeholder="000000" />
                        <p class="mt-2 text-xs text-gray-400">
                            Code expires in <span id="otp-timer" class="font-mono text-blue-600">5:00</span>
                        </p>
                    </div>

                    <button type="submit"
                        class="flex w-full justify-center rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-3 text-sm font-semibold leading-6 text-white shadow-md hover:from-blue-700 hover:to-blue-800 hover:shadow-lg transition-all">
                        Verify &amp; Continue
                    </button>
                </form>

                <div class="mt-5 text-center">
                    <form method="POST" action="{{ route('two-factor.resend') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-xs font-medium text-blue-600 hover:text-blue-700 transition-colors">
                            Didn't receive a code? Resend code
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts

    <script>
        @if (session('pipe_2fa_dispatched') && session('pipe_2fa_otp'))
        document.addEventListener('DOMContentLoaded', function() {
            var input = document.getElementById('otp');
            if (input) {
                input.value = '{{ session('pipe_2fa_otp') }}';
            }
        });
        @endif

        (function() {
            var timerEl = document.getElementById('otp-timer');
            if (timerEl) {
                var seconds = 300;
                var interval = setInterval(function() {
                    seconds--;
                    if (seconds <= 0) {
                        clearInterval(interval);
                        timerEl.textContent = 'Expired';
                        timerEl.classList.remove('text-blue-600');
                        timerEl.classList.add('text-red-600');
                        return;
                    }
                    var m = Math.floor(seconds / 60);
                    var s = seconds % 60;
                    timerEl.textContent = m + ':' + (s < 10 ? '0' : '') + s;
                }, 1000);
            }
        })();
    </script>
</body>
</html>
