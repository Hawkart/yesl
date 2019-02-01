<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <style type="text/css" rel="stylesheet" media="all">
        /* Media Queries */
        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
</head>

<?php
$style = [
    /* Layout ------------------------------ */
    'body' => 'margin: 0; padding: 0; width: 100%; background-color: #ffffff;',
    'email-wrapper' => 'width: 100%; margin: 0; padding: 0; background-color: #F2F4F6;',
    /* Body ------------------------------ */
    'body_action' => 'width: 100%; margin: 30px auto; padding: 0; text-align: center;',
    'body_sub' => 'margin-top: 25px; padding-top: 25px; border-top: 1px solid #EDEFF2;',
    /* Type ------------------------------ */
    'anchor' => 'color: #3869D4;',
    'header-1' => 'margin-top: 0; color: #000000; font-size: 19px; text-align: left;',
    'paragraph' => 'margin-top: 0; color: #000000; font-size: 16px; line-height: 1.5em;',
    'paragraph-sub' => 'margin-top: 0; color: #74787E; font-size: 12px; line-height: 1.5em;',
    'paragraph-center' => 'text-align: center;',
];
?>

<?php $fontFamily = 'font-family: Times New Roman, Helvetica, sans-serif;'; ?>

<body style="{{ $style['body'] }}">
<!-- Greeting -->
<p style="{{ $style['paragraph'] }}">
    Dear, Mr. {{ $data['title'] }}!
</h1>

<p style="{{ $style['paragraph'] }}">
    Would you mind getting the best Esports athletes on your team?
</p>
<p style="{{ $style['paragraph'] }}">
    Particularly for college Esports coaches, we have created the
    <a style="{{ $style['anchor'] }}" href="{{ url('/') }}" target="_blank">{{ config('app.name') }}</a> service to select the brilliant Esports athletes and
    attract them to your team.
</p>
<p style="{{ $style['paragraph'] }}">
    You will be able to publish team vacancies and receive
    filled applications from candidates by using <a style="{{ $style['anchor'] }}" href="{{ url('/') }}" target="_blank">{{ config('app.name') }}</a>.
    We will provide broad advertising campaign to attract outstanding
    Esports players to <a style="{{ $style['anchor'] }}" href="{{ url('/') }}" target="_blank">{{ config('app.name') }}</a> website.
</p>
<p style="{{ $style['paragraph'] }}">
    Our service is absolutely free-of-charge to coaches and athletes.
</p>
<p style="{{ $style['paragraph'] }}">
    Please let me know if you are interested in using our service
    so that I could provide you with the link for coach registration.
</p>

<!-- Salutation -->
<p style="{{ $style['paragraph'] }}">
    <br>
    Sincerely,<br><br>

    Vlad ILchenko<br>
    Founder of <a style="{{ $style['anchor'] }}" href="{{ url('/') }}" target="_blank">{{ config('app.name') }}</a>
</p>
</body>
</html>