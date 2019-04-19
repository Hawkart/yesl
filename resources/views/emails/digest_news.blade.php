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
    'body' => 'margin: 0; padding: 0; width: 100%; background-color: #F2F4F6;',
    'email-wrapper' => 'width: 100%; margin: 0; padding: 0; background-color: #F2F4F6;',
    /* Masthead ----------------------- */
    'email-masthead' => 'padding: 25px 0; text-align: center;',
    'email-masthead_name' => 'font-size: 16px; font-weight: bold; color: #2F3133; text-decoration: none; text-shadow: 0 1px 0 white;',
    'email-body' => 'width: 100%; margin: 0; padding: 0; border-top: 1px solid #EDEFF2; border-bottom: 1px solid #EDEFF2; background-color: #FFF;',
    'email-body_inner' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0;',
    'email-body_cell' => 'padding: 35px;',
    'email-footer' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0; text-align: center;',
    'email-footer_cell' => 'color: #AEAEAE; padding: 35px; text-align: center;',
    /* Body ------------------------------ */
    'body_action' => 'width: 100%; margin: 30px auto; padding: 0; text-align: center;',
    'body_sub' => 'margin-top: 25px; padding-top: 25px; border-top: 1px solid #EDEFF2;',
    /* Type ------------------------------ */
    'anchor' => 'color: #3869D4;',
    'header-1' => 'margin-top: 0; color: #000; font-size: 19px; font-weight: bold; text-align: left;',
    'paragraph' => 'margin-top: 0; color: #000; font-size: 16px; line-height: 1.5em;',
    'paragraph-sub' => 'margin-top: 0; color: #000; font-size: 12px; line-height: 1.5em;',
    'paragraph-center' => 'text-align: center;',
    /* Buttons ------------------------------ */
    'button' => 'display: block; display: inline-block; width: 200px; min-height: 20px; padding: 10px;
                 background-color: #3869D4; border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 25px;
                 text-align: center; text-decoration: none; -webkit-text-size-adjust: none;',
    'button--green' => 'background-color: #22BC66;',
    'button--red' => 'background-color: #dc4d2f;',
    'button--blue' => 'background-color: #3869D4;',
];
?>

<?php $fontFamily = 'font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;'; ?>

<body style="{{ $style['body'] }}">
<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td style="{{ $style['email-wrapper'] }}" align="center">
            <table width="100%" cellpadding="0" cellspacing="0">
                <!-- Logo -->
                <tr>
                    <td style="{{ $style['email-masthead'] }}">

                        <table align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <span style="{{ $fontFamily }} {{ $style['email-masthead_name'] }}">
                                        {{ config('app.name') }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Email Body -->
                <tr>
                    <td style="{{ $style['email-body'] }}" width="100%">
                        <table style="{{ $style['email-body_inner'] }}" align="center" width="570" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="{{ $fontFamily }} {{ $style['email-body_cell'] }}">
                                    <!-- Greeting -->
                                    <h1 style="{{ $style['header-1'] }}">
                                        Hey {{$data['name']}}!
                                    </h1>

                                    <!-- Intro -->
                                    <p style="{{ $style['paragraph'] }}">
                                        We keep bringing you the latest news about Esports and
                                        Esports scholarship opportunities at American universities and colleges.<br>
                                        You can find the most recent news below:
                                    </p>

                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        @foreach($data['news'] as $post)
                                            <tr>
                                                <td style="padding-bottom: 20px">
                                                    <p style="{{ $style['paragraph'] }}">
                                                        <a style="{{ $style['anchor'] }}" href="https://esportsathletes.net/news/{{$post->slug}}" target="_blank">{{$post->title}}</a>
                                                    </p>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>

                                    <p style="{{ $style['paragraph'] }}">
                                        Check you opportunities to get Esports scholarship by applying to the teams on
                                        CampusTeam website.<br>
                                        Should you have any questions about varsity Esports teams and scholarships, please do not
                                        hestitate to contact coaches directly or CampusTeam support by email:<br>
                                        support@campusteam.tv
                                    </p>

                                    <!-- Salutation -->
                                    <p style="{{ $style['paragraph'] }}">
                                        <br>Your<br>
                                        <span style="{{ $style['anchor'] }}">CampusTeam</span> crew
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td>
                        <table style="{{ $style['email-footer'] }}" align="center" width="570" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="{{ $fontFamily }} {{ $style['email-footer_cell'] }}">
                                    <p style="{{ $style['paragraph-sub'] }}">
                                        <a href="<%asm_global_unsubscribe_raw_url%>" style="{{$style['paragraph-center']}}">Unsubscribe</a><br>
                                        &copy; {{ date('Y') }}
                                        <span style="{{ $style['anchor'] }}">{{ config('app.name') }}</span>.
                                        All rights reserved.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
