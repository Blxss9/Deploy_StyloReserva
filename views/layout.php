<?php
// Inicializar variables con un valor predeterminado si no están definidas
$esLandingPage = $esLandingPage ?? false;
$esError404 = $esError404 ?? false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo ?? 'StyloReserva'; ?></title> <!-- Título dinámico o valor predeterminado --></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="/build/css/tailwind.css" rel="stylesheet">
    <link href="/build/css/app.css" rel="stylesheet">
    
    <script
        src="https://www.paypal.com/sdk/js?client-id=<?php echo PAYPAL_CLIENT_ID; ?>&currency=USD"
        data-sdk-integration-source="button-factory">
    </script>

    
    
</head>

    <body>
        <?php echo $contenido; ?>

        <script src="/build/js/flowbite.min.js"></script>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src="/build/js/app.js"></script>
    </body>
</html>