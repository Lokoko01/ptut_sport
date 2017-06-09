<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
</head>
<body>
    Bonjour {{$contact['studentEmail']}},
    <p>Pour vous inscrire veuillez <a href={{$contact['route']}}>cliquer ici</a>.</p>

{{--C'est ici pour modifier le template d'email de préinscription. Il faut mettre un template au format HTML.--}}
{{--Le lien vers le formulaire d'inscription est {{$contact['route']}},
il est impéritf de le garder dans l'email pour que les étiduants puissent s'inscrire (voir l'exemple actuel).--}}
</body>
</html>