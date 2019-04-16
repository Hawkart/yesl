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
</p>
<p style="{{ $style['paragraph'] }}">
We are happy to inform you that СampusTeam.tv has finally launched
its service which is aimed at connecting varsity coaches with Esports athletes.
</p>

<p style="{{ $style['paragraph'] }}">
The registration of Esports athletes is already open at <a style="{{ $style['anchor'] }}" href="{{ url('/') }}" target="_blank">www.campusteam.tv</a>.
Registered Esports athletes will be able to fill out the application form to the team and write a message to the Esports head coach.
</p>

<p style="{{ $style['paragraph'] }}">
To make it easier for you to select the Esports athletes, we will provide you with
access to database of athletes' resumes.<br/>
So that the players do not disturb you repeatedly, they will be allowed
to send messages directly only if they have fully completed the application form.
You will be receiving these messages with athletes' names in your work mailbox
sent from CampusTeam.tv domain.
</p>

<p style="{{ $style['paragraph'] }}">
To be able select the athletes, you are welcome to register on CampusTeam.tv website.
    Here is the link for coach registration: <a style="{{ $style['anchor'] }}" href="https://campusteam.tv/register-coach" target="_blank">https://campusteam.tv/register-coach</a>
</p>

<!-- Salutation -->
<p style="{{ $style['paragraph'] }}">
    <br>

    In case you have any questions, please feel free to contact me,<br><br>

    e-mail : vl@campusteam.tv<br>
    Mobile:  +1 315 636 5354<br>
    Skype:   vladislav.ilchenko<br>
    Discord: Vlad_ILchenko<br>
    LinkedIn: www.linkedin.com/in/vlad-ilchenko/<br><br>

    Vlad ILchenko<br>
    Founder of <a style="{{ $style['anchor'] }}" href="{{ url('/') }}" target="_blank">{{ config('app.name') }}</a>

    <a href="<%asm_global_unsubscribe_raw_url%>" style="{{$style['paragraph-center']}}">Unsubscribe</a><br>
</p>
</body>
</html>
