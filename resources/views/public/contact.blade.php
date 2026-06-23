<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Contact Us — PIPE</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
    <style>
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fade-up 0.5s ease-out forwards; opacity: 0; }
        .animate-fade-up-d1 { animation-delay: 0.1s; }
        .animate-fade-up-d2 { animation-delay: 0.2s; }
        .animate-fade-up-d3 { animation-delay: 0.3s; }
        .animate-fade-up-d4 { animation-delay: 0.4s; }
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
            <nav class="hidden md:flex items-center gap-1">
                <a href="/" class="rounded-lg px-3.5 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">Home</a>
                <a href="{{ route('mp-profiles') }}" class="rounded-lg px-3.5 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">MP's Profile</a>
                <a href="{{ route('gov-sites') }}" class="rounded-lg px-3.5 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">Gov Site</a>
                <a href="{{ route('our-team') }}" class="rounded-lg px-3.5 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80 transition-all">Our Team</a>
                <a href="{{ route('contact') }}" class="rounded-lg px-3.5 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 shadow-sm transition-all">Contact</a>
            </nav>
            <div class="hidden md:block">
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-lg bg-gradient-to-r from-blue-50 to-blue-100/80 px-4 py-2 text-sm font-semibold text-blue-700 ring-1 ring-blue-200/50 hover:from-blue-100 hover:to-blue-200/80 transition-all shadow-sm">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:from-blue-700 hover:to-blue-800 hover:shadow-md transition-all">Log in</a>
                @endauth
            </div>
            <button id="mobile-menu-btn" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="md:hidden p-2 text-gray-500 hover:text-gray-900 rounded-lg hover:bg-gray-100/80 transition-all">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
            </button>
        </div>
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200/80 bg-white/95 backdrop-blur-xl">
            <div class="px-4 py-3 space-y-1">
                <a href="/" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80">Home</a>
                <a href="{{ route('mp-profiles') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80">MP's Profile</a>
                <a href="{{ route('gov-sites') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80">Gov Site</a>
                <a href="{{ route('our-team') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100/80">Our Team</a>
                <a href="{{ route('contact') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700">Contact</a>
                <hr class="border-gray-200 my-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="block rounded-lg bg-gradient-to-r from-blue-50 to-blue-100/80 px-3 py-2.5 text-sm font-semibold text-blue-700 text-center">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-3 py-2.5 text-sm font-semibold text-white text-center shadow-sm">Log in</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="pt-24 pb-16 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="animate-fade-up text-center mb-12">
                <span class="inline-block rounded-full border border-blue-200/60 bg-gradient-to-r from-blue-50 to-blue-100/50 px-4 py-1.5 text-xs font-semibold tracking-wider uppercase text-blue-700 shadow-sm">Get in touch</span>
                <h1 class="mt-4 text-3xl sm:text-4xl font-bold tracking-tight text-gray-900">Contact Us</h1>
                <p class="mt-3 text-base text-gray-500 max-w-xl mx-auto">Have a question, suggestion, or need assistance? Reach out to the PIPE team — part of the <strong class="text-gray-700">Pokhara Research Centre</strong>.</p>
            </div>

            @if (session('status'))
                <div class="animate-fade-up mx-auto mb-8 max-w-2xl rounded-lg border border-green-200/60 bg-gradient-to-r from-green-50 to-green-100/50 p-4 text-sm text-green-700 shadow-sm">
                    <div class="flex items-start gap-3">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 max-w-5xl mx-auto">
                <div class="animate-fade-up animate-fade-up-d1 lg:col-span-2 space-y-6">
                    <div class="rounded-xl border border-gray-200/60 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-blue-50 to-blue-100/80 shadow-sm">
                                    <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-medium text-gray-900">Email</div>
                                    <a href="mailto:contact@pipe.gov" class="text-sm text-blue-600 hover:text-blue-700 transition-colors">contact@pipe.gov</a>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-blue-50 to-blue-100/80 shadow-sm">
                                    <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-medium text-gray-900">Location</div>
                                    <div class="text-sm text-gray-500">Parliament of South Africa<br />Cape Town, Western Cape</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-blue-50 to-blue-100/80 shadow-sm">
                                    <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-medium text-gray-900">Phone</div>
                                    <a href="tel:+27214000000" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">+27 21 400 0000</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-blue-200/60 bg-gradient-to-r from-blue-50 to-blue-100/50 p-6 shadow-sm">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="relative flex h-2 w-2"><span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-75"></span><span class="relative inline-flex h-2 w-2 rounded-full bg-blue-500"></span></span>
                            <span class="text-sm font-medium text-blue-900">Quick Response</span>
                        </div>
                        <p class="text-sm text-blue-700 leading-relaxed">
                            Our team typically responds within <strong>24 hours</strong>. For urgent enquiries, please use the <a href="{{ route('expert-query.submit') }}" class="font-medium underline hover:text-blue-900 transition-colors">Ask-An-Expert</a> system.
                        </p>
                    </div>
                </div>

                <div class="animate-fade-up animate-fade-up-d2 lg:col-span-3">
                    <form method="POST" action="{{ route('contact.store') }}" class="rounded-xl border border-gray-200/60 bg-white p-6 sm:p-8 shadow-sm space-y-5">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                                <input id="name" name="name" type="text" required value="{{ old('name') }}"
                                    class="block w-full rounded-lg border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm transition"
                                    placeholder="John Doe" />
                                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                                <input id="email" name="email" type="email" required value="{{ old('email') }}"
                                    class="block w-full rounded-lg border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm transition"
                                    placeholder="you@example.com" />
                                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1.5">Subject</label>
                            <input id="subject" name="subject" type="text" required value="{{ old('subject') }}"
                                class="block w-full rounded-lg border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm transition"
                                placeholder="How can we help you?" />
                            @error('subject') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1.5">Message</label>
                            <textarea id="message" name="message" required rows="6"
                                class="block w-full rounded-lg border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300/80 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm transition resize-y"
                                placeholder="Tell us more about your enquiry...">{{ old('message') }}</textarea>
                            @error('message') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <p class="text-xs text-gray-400">All fields are required</p>
                            <button type="submit"
                                class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-3 text-sm font-semibold text-white shadow-md hover:from-blue-700 hover:to-blue-800 hover:shadow-lg transition-all">
                                Send Message
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-gray-900 border-t border-gray-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 py-12">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-md bg-gradient-to-br from-blue-500 to-blue-600 shadow-sm">
                        <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5l8.5 5.5-8.5 5.5L3.5 13 12 7.5z" /></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-200">PIPE</span>
                    <span class="text-xs text-blue-400">Pokhara Research Centre</span>
                </div>
                <p class="text-xs text-gray-500">&copy; {{ date('Y') }} Province Information Portal and Engagement Platform.</p>
                <nav class="flex items-center gap-4 text-xs text-gray-500">
                    <a href="/" class="hover:text-gray-200 transition-colors">Home</a>
                    <a href="{{ route('mp-profiles') }}" class="hover:text-gray-200 transition-colors">MP's Profile</a>
                    <a href="{{ route('gov-sites') }}" class="hover:text-gray-200 transition-colors">Gov Site</a>
                    <a href="{{ route('our-team') }}" class="hover:text-gray-200 transition-colors">Our Team</a>
                </nav>
            </div>
        </div>
    </footer>

</body>
</html>
