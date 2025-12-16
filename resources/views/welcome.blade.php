<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mimate Estética - Realza tu Belleza</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .text-mimate-blue { color: #3b82f6; } 
        .bg-mimate-pink { background-color: #ffe4e6; } 
    </style>
</head>
<body class="bg-white text-slate-600 antialiased selection:bg-pink-200 selection:text-pink-900">

    <nav class="fixed w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-md shadow-sm border-b border-pink-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer" onclick="window.scrollTo(0,0)">
                    <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center text-2xl shadow-inner text-blue-400">
                        🌸
                    </div>
                    <div>
                        <span class="text-2xl font-bold text-blue-500 tracking-tight">Mimate</span>
                        <span class="text-lg font-light text-blue-400">Estética</span>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-slate-500 hover:text-blue-500 transition">
                                Ir al Panel
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-400 hover:text-blue-500 transition hidden sm:block">
                                Iniciar Sesión
                            </a>
                        @endauth
                    @endif

                    <a href="{{ route('booking.create') }}" class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-full text-white bg-gradient-to-r from-blue-400 to-blue-500 hover:from-blue-500 hover:to-blue-600 shadow-lg shadow-blue-200 transition transform hover:-translate-y-0.5">
                        📅 Agendar Cita
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="relative pt-32 pb-20 sm:pt-40 sm:pb-24 overflow-hidden">
        <div class="absolute top-0 left-1/2 w-full -translate-x-1/2 h-full z-0">
            <div class="absolute top-20 left-10 w-72 h-72 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-20 right-10 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        </div>

        <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-pink-50 border border-pink-100 text-pink-500 text-sm font-semibold mb-6 tracking-wide uppercase">
                Bienvenida a tu espacio
            </span>
            <h1 class="text-5xl md:text-7xl font-bold text-slate-800 tracking-tight mb-6">
                Realza tu <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-blue-500">Belleza</span>, <br>
                Relaja tu <span class="text-blue-400">Mente</span>.
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-slate-500 leading-relaxed">
                Tratamientos faciales y corporales diseñados para ti. 
                Descubre la mejor versión de ti misma en un ambiente profesional y seguro.
            </p>
            
            <div class="mt-10 flex justify-center gap-4">
                <a href="{{ route('booking.create') }}" class="px-8 py-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-2xl shadow-xl shadow-blue-200 transition transform hover:scale-105 flex items-center gap-2">
                    ✨ Reservar Ahora
                </a>
                <a href="#servicios" class="px-8 py-4 bg-white hover:bg-gray-50 text-slate-600 font-semibold rounded-2xl border border-gray-200 shadow-sm transition">
                    Ver Tratamientos
                </a>
            </div>
        </div>
    </div>

    <div id="servicios" class="py-20 bg-gradient-to-b from-white to-pink-50/30">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-800 mb-4">Nuestros Favoritos</h2>
                <div class="w-20 h-1 bg-pink-400 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($services as $service)
                <div class="bg-white rounded-3xl p-8 shadow-lg shadow-pink-100/50 border border-pink-50 hover:border-pink-200 transition group hover:-translate-y-2 duration-300">
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-blue-500 group-hover:text-white transition">
                        💎
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">{{ $service->name }}</h3>
                    <p class="text-slate-500 text-sm mb-6 line-clamp-3">
                        {{ $service->description }}
                    </p>
                    <div class="flex items-center justify-between mt-auto">
                        <span class="text-2xl font-bold text-blue-500">${{ number_format($service->price, 0) }}</span>
                        <a href="{{ route('booking.create') }}" class="text-sm font-semibold text-pink-500 hover:text-pink-600 flex items-center gap-1 group-hover:underline">
                            Reservar <span class="text-lg">→</span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('booking.create') }}" class="inline-block text-slate-500 hover:text-blue-500 font-medium transition border-b border-transparent hover:border-blue-500">
                    Ver todos los servicios disponibles
                </a>
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-100 pt-12 pb-8">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <div class="flex items-center justify-center gap-2 mb-6">
                <span class="text-2xl">🌸</span>
                <span class="text-xl font-bold text-blue-500">Mimate Estética</span>
            </div>
            <p class="text-slate-400 text-sm mb-8">
                Tu centro de confianza para el cuidado personal y bienestar.
            </p>
            <div class="flex justify-center gap-6 mb-8">
                <a href="#" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-pink-100 hover:text-pink-500 transition">
                    IG
                </a>
                <a href="https://wa.me/593992162968" target="_blank" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-green-100 hover:text-green-500 transition">
                    WA
                </a>
            </div>
            <p class="text-xs text-slate-300">
                &copy; {{ date('Y') }} Mimate Estética. Todos los derechos reservados.
            </p>
        </div>
    </footer>

    <style>
        /* Animación suave para las burbujas de fondo */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
    </style>
</body>
</html>