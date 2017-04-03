<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
</head>
<body>
    Bonjour {{$contact['studentEmail']}},
    <p>Pour vous inscrire veuillez <a href="http://tygrysko.sytes.net/register/{{$contact['studentEmail']}}/{{$contact['token']}}">cliquer ici</a>.</p>
</body>
</html>