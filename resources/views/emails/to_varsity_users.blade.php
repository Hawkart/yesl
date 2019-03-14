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
                <tr>
                    <td style="{{ $style['email-body'] }}" width="100%">
                        <table style="{{ $style['email-body_inner'] }}" align="center" width="570" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="{{ $fontFamily }} {{ $style['email-body_cell'] }}">
                                    <!-- Greeting -->
                                    <h1 style="{{ $style['header-1'] }}">
                                        Dear {{$data['name']}},
                                    </h1>

                                    <!-- Intro -->
                                    <p style="{{ $style['paragraph'] }}">
                                        Have you ever thought about getting an Esports scholarship?
                                    </p>

                                    <p style="{{ $style['paragraph'] }}">
                                        Nowadays, more than 100 US colleges have Esports scholarships amounting
                                        to $15 million per year.<br/>
                                        The average esports scholarship covers the half off tuition, but some athletes
                                        can obtain up to 100% of tuition coverage and full coverage of accommodation
                                        and textbooks' costs.
                                    </p>

                                    <p style="{{ $style['paragraph'] }}">
                                        For you and your friends, we have collected US universities and colleges
                                        with Esports programs in one place <a style="{{ $style['anchor'] }}" href="{{ url('/?utm_source=email&utm_medium=email&utm_campaign=varsityesports') }}" target="_blank">www.СampusTeam.tv</a>.
                                    </p>

                                    <p style="{{ $style['paragraph'] }}">
                                        At www.CampusTeam.tv, you can choose a college/university with
                                        an Esports team by major, location, and amount of tuition.
                                    </p>
                                    <p style="{{ $style['paragraph'] }}">
                                        You can reach university coaches via chat to discuss your chances of getting
                                        an Esports scholarship.
                                    </p>
                                    <p style="{{ $style['paragraph'] }}">
                                        Registration is free, and there is no monthly fee for keeping your resume
                                        in the database.
                                    </p>

                                    <!-- Action Button -->
                                    <table style="{{ $style['body_action'] }}" align="center" width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="center">
                                                <?php
                                                $actionColor = 'button--blue';
                                                ?>

                                                <a href="{{ url('register?utm_source=email&utm_medium=email&utm_campaign=varsityesports') }}"
                                                   style="{{ $fontFamily }} {{ $style['button'] }} {{ $style[$actionColor] }}"
                                                   class="button"
                                                   target="_blank">
                                                    Register
                                                </a>
                                            </td>
                                        </tr>
                                    </table>

                                    <p style="{{ $style['paragraph'] }}">
                                        If you have any questions you can reach me via email VL@CampusTeam.tv
                                        or by Discord Vlad_ILchenko#2047,<br> and I will try to get back to you shortly.
                                    </p>

                                    <p style="{{ $style['paragraph'] }}">
                                        Good luck!
                                    </p>
                                    <br>

                                    <!-- Salutation -->
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <!-- Logo -->
                                        <tr>
                                            <td width="60px">
                                                <img src="{{url('/storage/vlad.jpeg')}}" style="width: 50px; padding-right: 20px"/>
                                            </td>
                                            <td>
                                                <p style="{{ $style['paragraph'] }}">
                                                    Vlad ILchenko<br>
                                                    CEO at CampusTeam
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                    <br>

                                    <p style="{{ $style['paragraph-sub'] }}">
                                        We are sending this email to you as we think that the information
                                        about esports scholarships could be interesting for you.
                                        Please let us know if you do not want to get emails from us in the future.
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
