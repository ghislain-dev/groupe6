<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$apiKey = "4c98a7f3f3a6e06aac36a2aacee7e3ab";  // Mets ta clé API ici
$ville = isset($_GET['ville']) ? htmlspecialchars($_GET['ville']) : 'Paris'; // Valeur par défaut : Paris

if (!empty($ville)) {
    $url = "https://api.openweathermap.org/data/2.5/weather?q={$ville}&appid={$apiKey}&units=metric&lang=fr";

    // Récupération des données
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data && isset($data['main']['temp'])) {
        $temp = $data['main']['temp'];
        $desc = ucfirst($data['weather'][0]['description']);
    } else {
        $error = "Ville non trouvée ou erreur lors de la récupération des données.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Météo en temps réel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <header>
        <?php
            include('header.php');
        ?>
    </header>
    <center>
    <div class="row m-5">
      
        <div class="col-md-6">
            <center>
            <h2>Obtenir la météo</h2>
            <form method="GET">
                <input type="text"class="form-control" name="ville" placeholder="Entrez une ville" required>
                <button class="btn btn-info m-4" type="submit">Rechercher</button>
            </form>
            </center>
        </div>
        <div class="col-md-6">
            <center>
            <?php if (!empty($ville) && isset($temp)): ?>
                <h3>Météo à <?php echo htmlspecialchars($ville); ?></h3>
                <p>Température : <?php echo $temp; ?>°C</p>
                <p>Condition : <?php echo $desc; ?></p>
            <?php elseif (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            </center>
        </div>
    </div>
    </center>
    
   

</body>
</html>
