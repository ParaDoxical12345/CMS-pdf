<h4>
    MDC Clinic <br>
    Tubigon, Bohol
</h4>

<h1>Appointment Confirmation</h1>

<p>
    Dear  {{$user->firstname}}!
</p>
<p>
    We are pleased to confirm your upcoming appointment with Dr. {{ $doctor->user->firstname }} {{ $doctor->user->lastname }}
    on {{ \Carbon\Carbon::parse($appointment->date)->format('F d, Y') }} at {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}.
    We look forward to providing you with our healthcare services.
    <br>
    Please ensure that you arrive at our facility promptly and are prepared for your appointment.
    <br>
    Your health and well-being are important to us, and we are committed to delivering the highest level of care.
    <br><br>
    Sincerely,
    <br>
    MDC Clinic
</p>
<div class="footer">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="content-block">
          <span class="apple-link">Mater Dei College </span>
          <br> Clinic Management System <span>V.1</span>.
        </td>
      </tr>

    </table>
  </div>

