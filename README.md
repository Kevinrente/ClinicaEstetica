🌸 Mimate Estética - Sistema de Gestión Clínica (ERP)
Sistema integral para la gestión de centros estéticos y clínicas dermatológicas. Desarrollado con Laravel, incluye gestión de agenda, historial clínico, consentimientos digitales, control financiero e integración con Inteligencia Artificial (Llama 3 vía Groq) para la redacción automática de informes médicos.

🚀 Características Principales
📅 Agenda Inteligente:

Reserva de citas interna (Admin) y pública (Landing Page para clientes).

Detección automática de conflictos de horario.

🩺 Gestión Clínica Avanzada:

Expediente digital del paciente.

Asistente IA: Redacción automática de notas de evolución usando Llama 3.

Carga de fotografías (Antes/Después).

✍️ Legal & Consentimientos:

Firma digital manuscrita (Signature Pad).

Generación de contratos dinámicos según el servicio (Láser, Invasivos, Faciales).

💰 Finanzas & Dashboard:

Control de caja diario.

Reportes de ingresos y métricas de rendimiento.

Calculadora de comisiones para empleados.

🎂 CRM:

Detector automático de cumpleaños (7 días próximos).

📦 Inventario: Control de stock de insumos.

🛠️ Requisitos del Sistema
Para ejecutar este proyecto en otra máquina necesitas:

PHP >= 8.2

Composer (Gestor de dependencias PHP)

Node.js & NPM (Para el frontend)

PostgreSQL (Base de datos recomendada) o MySQL/MariaDB.

Git

🔧 Guía de Instalación (Paso a Paso)
Sigue estos pasos para levantar el proyecto en una computadora nueva:

1. Clonar el Repositorio
Bash

git clone https://github.com/Kevinrente/ClinicaEstetica.git
cd ClinicaEstetica
2. Instalar Dependencias
Instala las librerías de backend y frontend:

Bash

composer install
npm install
3. Configurar el Entorno (.env)
Duplica el archivo de ejemplo y renómbralo:

Bash

cp .env.example .env
Abre el archivo .env y configura tu base de datos:

Ini, TOML

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=mimate_db
DB_USERNAME=tu_usuario_postgres
DB_PASSWORD=tu_contraseña
4. Configurar la Inteligencia Artificial (Groq)
Para que funcione el botón "Mejorar con IA", obtén una API Key gratis en Groq Console y añádela al final de tu .env:

Ini, TOML

GROQ_API_KEY=gsk_tu_clave_secreta_aqui...
GROQ_MODEL=llama-3.3-70b-versatile
5. Generar Clave y Migrar Base de Datos
Bash

php artisan key:generate
php artisan migrate --seed
> Nota: El comando --seed es crucial porque carga el usuario Administrador y el catálogo completo de servicios (Láser, Faciales, etc.).

6. Compilar Assets y Ejecutar
En una terminal:

Bash

npm run build
En otra terminal (para mantener el servidor activo):

Bash

php artisan serve
El sistema estará disponible en: http://127.0.0.1:8000

📖 Manual de Uso Rápido
🔐 Acceso Administrativo
URL: /login

Usuario por defecto (Seeder): admin@mimate.com (o el que hayas configurado).

Contraseña: password

🌍 Reservas Públicas (Clientes)
Los clientes pueden acceder a la raíz del sitio (/) para ver la Landing Page.

Hacen clic en "Agendar Cita".

Seleccionan tratamiento, fecha y hora.

El sistema crea el paciente automáticamente si es nuevo (basado en el teléfono).

🤖 Cómo usar la IA en Consulta
Ve al Dashboard o Agenda.

Busca una cita próxima y haz clic en "Atender →".

En el campo "Notas de Evolución", escribe ideas sueltas (ej: "pte vino con piel seca, se hizo hidratacion").

Haz clic en el botón morado "✨ Mejorar con IA".

El sistema redactará un informe médico profesional automáticamente.

📂 Estructura Clave del Proyecto
app/Services/GroqService.php: Lógica de conexión con la IA.

database/seeders/ServiceSeeder.php: Catálogo de precios y textos legales.

resources/views/booking: Vistas de la parte pública.

resources/views/consents: Lógica de firma digital.

🤝 Contribución
Si deseas hacer cambios:

Haz un fork del proyecto.

Crea una rama (git checkout -b feature/nueva-funcion).

Haz commit de tus cambios.

Haz push a la rama.

Abre un Pull Request.

Desarrollado para Mimate Estética 🌸