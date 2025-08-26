<x-mail::message>
    <h2>Dear Administrator,</h2>
    <p>I hope you are doing well. We are inform you that you have received a new get in touch request.</p>
    <p>Below are the key details of customer:</p>
    <ul>
        <li><b>Customer Name: </b> {{ $maildata['name'] ?? '' }} </li>
        <li><b>Customer Email: </b> {{ $maildata['email'] ?? '' }} </li>
        <li><b>Customer Phone: </b> {{ $maildata['phone'] ?? '' }} </li>
        @if (!empty($maildata['subject']))
            <li><b>Subject: </b> {{ $maildata['subject'] ?? '' }} </li>
        @endif
        <li><b>Message: </b> {{ $maildata['message'] ?? '' }} </li>
    </ul>
    <p>
        Best regards,<br>
        {{ config('app.name') }} Team
    </p>
</x-mail::message>
