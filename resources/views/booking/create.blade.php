<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reserva tu Cita - Mimate Estética</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-3xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-2xl">🌸</span>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Mimate<span class="text-pink-500">Estética</span></h1>
            </div>
            <a href="https://wa.me/593992162968" target="_blank" class="text-sm font-medium text-green-600 hover:text-green-700 flex items-center gap-1">
                ¿Ayuda? WhatsApp
            </a>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 py-8">
        
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Agenda tu momento de relax</h2>
            <p class="text-gray-500">Selecciona el tratamiento ideal y reserva en segundos.</p>
        </div>

        <form action="{{ route('booking.store') }}" method="POST" class="space-y-8">
            @csrf

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="bg-pink-100 text-pink-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">1</span>
                    Elige tu Tratamiento
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($services as $service)
                    <label class="cursor-pointer relative">
                        <input type="radio" name="service_id" value="{{ $service->id }}" class="peer sr-only" required>
                        <div class="p-4 rounded-xl border-2 border-gray-100 peer-checked:border-pink-500 peer-checked:bg-pink-50 transition-all hover:border-pink-200 h-full flex flex-col justify-between">
                            <div>
                                <div class="font-bold text-gray-800">{{ $service->name }}</div>
                                <div class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $service->description }}</div>
                            </div>
                            <div class="mt-3 flex justify-between items-center">
                                <span class="text-pink-600 font-bold">${{ number_format($service->price, 0) }}</span>
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">{{ $service->duration }} min</span>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="bg-pink-100 text-pink-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">2</span>
                    ¿Cuándo te gustaría venir?
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                        <input type="date" name="appointment_date" min="{{ date('Y-m-d') }}" required
                               class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hora Preferida</label>
                        <select name="appointment_time" required class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition">
                            <option value="">Selecciona una hora...</option>
                            <option value="09:00">09:00 AM</option>
                            <option value="10:00">10:00 AM</option>
                            <option value="11:00">11:00 AM</option>
                            <option value="12:00">12:00 PM</option>
                            <option value="14:00">02:00 PM</option>
                            <option value="15:00">03:00 PM</option>
                            <option value="16:00">04:00 PM</option>
                            <option value="17:00">05:00 PM</option>
                            <option value="18:00">06:00 PM</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="bg-pink-100 text-pink-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">3</span>
                    Tus Datos
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                        <input type="text" name="name" placeholder="Ej: María Pérez" required
                               class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono / WhatsApp</label>
                            <input type="tel" name="phone" placeholder="099..." required
                                   class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Correo (Opcional)</label>
                            <input type="email" name="email" placeholder="maria@ejemplo.com"
                                   class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition">
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-pink-200 transition transform hover:scale-[1.02]">
                ✨ Confirmar Reserva
            </button>
            <p class="text-center text-xs text-gray-400 mt-4">Al reservar aceptas nuestros términos de servicio. El pago se realiza en el local.</p>

        </form>
    </div>

</body>
</html>