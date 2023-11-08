<h4>
    MDC Clinic <br>
    Tubigon, Bohol
</h4>

<h1>Appointment Cancellation</h1>

<p>
    Dear  {{$user->firstname}}!
</p>
    <p>
        I hope this message finds you well.
        We regret to inform you that your upcoming appointment scheduled for  {{ \Carbon\Carbon::parse($appointment->date)->format('F d, Y') }} at {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}  has been canceled.
        We apologize for any inconvenience this may cause and understand the importance of your healthcare needs.
        <br>
        Your health and well-being are of utmost importance to us, and we look forward to the opportunity to serve you in the future.
        <br>
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
<style>
     .footer td,
        .footer p,
        .footer span,
        .footer a {
          color: #999999;
          font-size: 12px;
          text-align: center;
      }

</style>
