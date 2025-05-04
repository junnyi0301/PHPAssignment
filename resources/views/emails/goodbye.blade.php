@component('mail::message')
<style>
    .header {
        color: #ff6b6b;
        font-size: 24px;
        margin-bottom: 20px;
    }
    .content {
        line-height: 1.6;
        margin-bottom: 25px;
    }
    .highlight-box {
        background-color: #f8f8f8;
        border-left: 4px solid #ff6b6b;
        padding: 15px;
        margin: 20px 0;
    }
</style>

<div style="text-align: center;">
    <img src="{{ asset('images/sushi-logo.png') }}" alt="Sushi Logo" class="logo">
</div>

<div class="header">
    🍣 Your Sushi Account Has Been Deleted
</div>

<div class="content">
    We're sorry to see you go, {{ $user->name }}. As per your request, your Sushi account and all associated data have been permanently deleted.
</div>

<div class="highlight-box">
    <strong>Important:</strong> This action cannot be undone. If you didn't request this change or wish to recover your account, please contact our support team immediately.
</div>

<div class="content">
    If you change your mind in the future, you're always welcome to create a new account with us.
</div>

@component('mail::button', ['url' => config('app.url'), 'color' => 'primary'])
    Visit Sushi Homepage
@endcomponent

<div style="margin-top: 30px; font-style: italic;">
    We appreciate the time you spent with us,<br>
    The Sushi Team
</div>

<div style="font-size: 12px; color: #999; margin-top: 30px;">
    This is an automated message. Please do not reply directly to this email.
</div>
@endcomponent