<!DOCTYPE html>
<html>
<head>
    <title>Consentimiento Informado</title>
    <style>
        body { font-family: sans-serif; padding: 40px; }
        .header { text-align: center; margin-bottom: 40px; border-bottom: 1px solid #ccc; padding-bottom: 20px; }
        .title { font-size: 20px; font-weight: bold; text-transform: uppercase; color: #333; }
        .content { font-size: 14px; line-height: 1.6; text-align: justify; margin-bottom: 50px; }
        .signature-box { text-align: center; margin-top: 50px; }
        .footer { position: fixed; bottom: 0; left: 0; right: 0; font-size: 10px; text-align: center; color: #777; }
    </style>
</head>
<body>

    <div class="header">
        <h1 class="title">Mimate Estética</h1>
        <p>Consentimiento Informado Digital</p>
    </div>

    <div class="content">
        <p>
            <strong>Fecha:</strong> {{ $date }} <br>
            <strong>Paciente:</strong> {{ $appointment->patient->full_name }} <br>
            <strong>Tratamiento:</strong> {{ $appointment->service->name }}
        </p>

        <p>
            Por medio del presente documento, yo, identificado/a como aparece al pie de mi firma, declaro que he sido informado/a detalladamente sobre el procedimiento estético denominado <strong>{{ $appointment->service->name }}</strong>.
        </p>
        <p>
            He comprendido la naturaleza, el propósito, los beneficios, los riesgos y las posibles complicaciones del procedimiento. He tenido la oportunidad de hacer preguntas y todas han sido respondidas a mi satisfacción.
        </p>
        <p>
            Confirmo que he informado al profesional tratante sobre mis antecedentes médicos, alergias y medicamentos actuales de manera veraz.
        </p>
    </div>

    <div class="signature-box">
        <img src="{{ $signature }}" width="300" style="border-bottom: 1px solid #000;">
        <p>Firma del Paciente</p>
        <p>{{ $appointment->patient->full_name }}</p>
    </div>

    <div class="footer">
        Documento generado electrónicamente por Mimaie App el {{ $date }}. Validez Legal.
    </div>

</body>
</html>