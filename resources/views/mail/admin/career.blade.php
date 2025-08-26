<x-mail::message>
    <h2>Hi Administrator,</h2>
    <p>We have received a new inquiry through the Career on our website.</p>
    <p><b>Inquiry Details:</b></p>
    <ul>
        <li><b>Name:</b> {{ $mail['name'] ?? '' }}</li>
        <li><b>Email:</b> {{ $mail['email'] ?? '' }}</li>
        <li><b>Phone Number:</b> {{ $mail['phone'] ?? '' }}</li>
        <li><b>Resume:</b> <a href="{{ \Image::showFile('resume',0,($mail['resume'] ?? '')) }}" download>Download Resume</a></li>
        <li><b>Experience:</b> {{ $mail['experience'] ?? '0' }} Years</li>
        <li><b>Message:</b> {{ $mail['message'] ?? '' }}</li>
    </ul>
    <p>Best regards,<br>
        {{ config('app.name') }}</p>
</x-mail::message>
