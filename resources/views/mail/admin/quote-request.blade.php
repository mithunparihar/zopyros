<x-mail::message>
    <h2>Dear Administrator,</h2>
    <p>I hope you're doing well. It is to inform you that a new {{ $requestType }} request have been placed on
        {{ \Content::ProjectName() }} website.</p>
    <p>User details are as follows:</p>
    <ul>
        <li><b>Customer Name: </b> {{ $maildata['name'] ?? '' }} </li>
        <li><b>Customer Email: </b> {{ $maildata['email'] ?? '' }} </li>
        <li><b>Customer Phone: </b> {{ $maildata['phone'] ?? '' }} </li>
        <li><b>Customer Message: </b> {{ $maildata['message'] ?? '' }} </li>
        <li><b>Product: </b> {{ $maildata['productInfo']['title'] ?? '' }} </li>
        <li><b>Color: </b> {{ $maildata['color_variant'] ?? '' }} </li>
        <li><b>Size: </b> {{ $maildata['size_variant'] ?? '' }} </li>
        <li><b>Material: </b> {{ $maildata['material_variant'] ?? '' }} </li>
    </ul>
    <p>
        Best regards,<br>
        {{ config('app.name') }} Team
    </p>
</x-mail::message>
