<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification sur les requêtes de prière</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
       body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }
        .email-headerlg {
            background-color: white;
            padding: 20px;
            text-align: center;
        }
        .email-header {
            background-color: #650F1C;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .email-headerlg img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .email-content {
            padding: 20px;
        }
        .email-content .btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: #650F1C;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
        }
        .email-content .btn:hover {
            background-color: #650F1C;
        }
        .email-footer {
            background-color: #650F1C;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: white;
        }
        .social-icons {
            margin-top: 10px;
        }
        .social-icons img {
            width: 24px;
            margin: 0 5px;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- En-tête avec le logo -->
        <div class="email-headerlg">
            <img src="{{ asset('storage/'.$site->site_logo) }}" alt="Logo de l'entreprise">

        </div>
        <div class="email-header">
            <h1>Notification sur les requêtes de prière</h1>
        </div>

        <!-- Contenu principal -->
        <div class="email-content">
            <h2>Bonjour {{ $userName }},</h2>
            <p>Nous tenons à vous informer qu'une requête de prière a été <strong>{{ $action }}</strong> :</p>
            <blockquote style="border-left: 4px solid #650F1C; padding-left: 10px; margin: 10px 0; color: #555;">
                {{ $messageContent }}
            </blockquote>
            <p>Si vous avez des questions ou des préoccupations, n'hésitez pas à contacter l'administrateur.</p>

            <!-- Bouton de connexion -->
            <a href="{{ url(config('app.url').'/administrateur') }}" class="btn">Aller sur la partie admin</a>

            <p>Cordialement,</p>
            <p><strong>L'équipe de {{ config('app.name') }}</strong></p>
        </div>

        <!-- Pied de page -->
        <div class="email-footer">
            <p>Vous recevez cet e-mail parce que vous avez choisi de recevoir des notifications.</p>
            <p>Suivez-nous sur :</p>
            <div class="social-icons">

                        <a href="{{ $settings['facebook'] }}" target="blank" {{ $settings['facebook']??"hidden" }}> <i class="fab fa-facebook"></i> </a>


                        <a href="{{ $settings['x_twitter'] }}" target="blank"
                        {{ $settings['x_twitter']??"hidden" }}> <i class="fab fa-x"></i> </a>


                        <a href="{{ $settings['instagram'] }}" target="blank"
                        {{ $settings['instagram']??"hidden" }}> <i class="fab fa-instagram"></i> </a>


                        <a href="{{ $settings['youtube'] }}" target="blank"
                        {{ $settings['youtube']??"hidden" }}> <i class="fab fa-youtube"></i> </a>


            </div>
        </div>
    </div>
</body>

</html>
