<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>¡Reserva Confirmada! - Mimate Estética</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen px-4">

    <div class="bg-white p-8 rounded-3xl shadow-xl max-w-md w-full text-center border-t-8 border-pink-500">
        
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <span class="text-4xl">✅</span>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-2">¡Solicitud Recibida!</h1>
        <p class="text-gray-500 mb-8">
            Tu cita ha sido agendada correctamente. Te esperamos en <strong>Mimate Estética</strong> para consentirte.
        </p>

        <div class="bg-pink-50 rounded-xl p-4 mb-8 text-left">
            <h3 class="text-sm font-bold text-pink-800 uppercase mb-2">Recordatorio:</h3>
            <ul class="text-sm text-pink-700 space-y-1">
                <li>• Llega 5 minutos antes.</li>
                <li>• El pago se realiza en el local.</li>
                <li>• Si no puedes asistir, avísanos.</li>
            </ul>
        </div>

        <a href="{{ route('booking.create') }}" class="block w-full bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 rounded-xl transition shadow-lg">
            Volver al Inicio
        </a>
        
        <a href="https://wa.me/593992162968" class="block mt-4 text-sm text-gray-400 hover:text-pink-500">
            ¿Tienes dudas? Escríbenos al WhatsApp
        </a>

    </div>

</body>
</html>