<x-mail::message>
# Welcome to the Team, {{ $employee->name }}!

Your account for the **{{ config('app.name') }}** has been successfully created. You can now access your dashboard using the temporary credentials provided below:

<x-mail::panel>
**Email Address:** {{ $employee->email }}  
**Temporary Password:** `{{ $password }}`
</x-mail::panel>

<x-mail::button :url="route('admin.login')">
Login to Dashboard
</x-mail::button>

**Important Security Notice:** For security purposes, you will be required to change this temporary password upon your first login. Please ensure your new password meets the required security standards.

If you encounter any issues during the login process, please contact our technical support team.

Best regards,  
**{{ config('app.name') }} Administration**
</x-mail::message>