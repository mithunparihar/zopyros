<x-mail::message>
    <h2>Dear {{ $user['name'] ?? 'User' }}</h2>
    <p>We received a request to reset the password for your account associated with this email address. If you made this request, please click the link below to change your password:</p><br>
    <p><a href="{{ route('admin.resetpasswordget',['token'=>$token]) }}">{{ route('admin.resetpasswordget',['token'=>$token]) }}</a></p><br>
    <p>If you did not request a password reset, please ignore this email, and no changes will be made to your account.</p>
    <p>
        Best regards,<br>
        {{ \Content::ProjectName() }} Support Team
    </p>
</x-mail::message>
