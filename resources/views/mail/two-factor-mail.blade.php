<x-mail::message>
<h2>Dear Customer,</h2>
<p>To enhance the security of your account, we have implemented 2-Step Verification. This adds an extra layer of protection to your account by requiring not only your password but also a verification code sent to your registered email.</p>
<p><b>Your 2-Step Verification Code: {{ $mailData['otp'] ?? '' }}</b></p>
<p>This OTP will be valid for next 10 minuts. Please enter this code on the verification page to complete your login.</p>
<p><b>Why 2-Step Verification?</b></p>
<ul>
    <li><b>Increased Security:</b> Even if someone knows your password, they won’t be able to access your account without the verification code.</li><br>
    <li><b>Protection from Unauthorized Access:</b> Prevents unauthorized users from accessing your account, even if your password is compromised.</li>
</ul>
<p><b>What to do if you didn't request this code?</b></p>
<p>If you did not request a verification code or suspect any unauthorized activity on your account, please:</p>
<ul>
    <li><b>Change your password immediately:</b> Go to your account settings and update your password.</li><br>
    <li><b>Contact our support team:</b> Reach out to us at [Support Email/Phone Number] for further assistance.</li>
</ul>
<p><b>Need Help?</b></p>
<p>If you have any questions or need assistance with 2-Step Verification, please contact our support team at <a href="mailto:{{ \Content::supportMail() }}">{{ \Content::supportMail() }}</a>.</p>
<p>Thank you for helping us keep your account secure.</p>
<p>
Best regards,<br>
{{ config('app.name') }} Team
</p>
</x-mail::message>
