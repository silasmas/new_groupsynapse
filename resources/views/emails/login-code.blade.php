<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .code-box { background: #f5f5f5; border: 2px dashed #FD0101; padding: 20px; text-align: center; font-size: 28px; font-weight: bold; letter-spacing: 8px; margin: 20px 0; }
        .footer { margin-top: 30px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Code de connexion</h2>
        <p>Utilisez le code suivant pour vous connecter à votre compte :</p>
        <div class="code-box">{{ $code }}</div>
        <p>Ce code expire dans {{ $expiresInMinutes }} minutes. Ne le partagez avec personne.</p>
        <div class="footer">
            <p>Si vous n'avez pas demandé ce code, ignorez cet email.</p>
            <p>&copy; {{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
