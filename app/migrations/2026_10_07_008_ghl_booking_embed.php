<?php
/**
 * Uses the practice's GoHighLevel booking widget (same calendar as the old site's
 * Make Appointment page) wherever the appointment form appears: the homepage "Book your visit"
 * section and /make-appointment/. Editable later in Settings → Integrations.
 */
return function (): array {
    $embed = '<iframe src="https://api.leadconnectorhq.com/widget/booking/PLsVbF7QB2xFRgmyLj1H" style="width: 100%;border:none;overflow: hidden;" scrolling="no" id="PLsVbF7QB2xFRgmyLj1H_1758145927808"></iframe><br><script src="https://link.msgsndr.com/js/form_embed.js" type="text/javascript"></script>';
    $had = trim((string)Settings::get('ghl_appointment_embed', '')) !== '';
    Settings::set('ghl_appointment_embed', $embed);
    return ['ghl_appointment_embed set' . ($had ? ' (replaced the previous embed)' : '')];
};
