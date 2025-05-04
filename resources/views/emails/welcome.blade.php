@component('mail::message')
<style>
    .header {
        color: #ff6b6b;
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 20px;
    }
    .content {
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 25px;
    }
    .signature {
        margin-top: 30px;
        font-style: italic;
    }
</style>

<div class="header">
    🍣 Welcome to Sushi, {{ $user->name }}!
</div>

<div class="content">
    Thank you for joining our community! We're thrilled to have you on board and can't wait for you to explore all the delicious features we offer.
</div>

@component('mail::button', ['url' => url('/home'), 'color' => 'success'])
    Explore Your Dashboard
@endcomponent

<div class="content">
    If you have any questions or need assistance, don't hesitate to reach out to our support team.
</div>

<div class="signature">
    Happy exploring,<br>
    The Sushi Team
</div>
@endcomponent