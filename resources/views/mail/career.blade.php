<x-mail::message>
    <h3>Dear {{ $mail['name'] }},</h3>
    <p>Thank you for your interest at {{ \Content::ProjectName() }}. We have received your application, and we appreciate the time and effort you put into applying.</p>
    <p>Our team is currently reviewing all applications, and we will be in touch if your qualifications match what we’re looking for in the role. In the meantime, please feel free to reach out if you have any questions about the application process.</p>
    <p>We appreciate your interest in joining {{ \Content::ProjectName() }} and wish you the best of luck.</p>
    <p>Best regards,<br>
        {{ config('app.name') }}</p>
</x-mail::message>
