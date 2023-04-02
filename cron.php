<?php
    // Ejecutar comando artisan para correr las tareas programadas
    // No funciona en hostinguer porque internamente corre con una versión inferior PHP a la 8.1 (necesaria para correr Laravel 10)
    // $out = exec('php /home/u594920092/domains/sac-monitoreo.online/alert-code/artisan schedule:run');
    // echo $out;
    
    //Alternativa para solucionar este problema
    //Hacer petición a una ruta predefinida con el código de la tarea programada
    $url = 'https://alert.sac-monitoreo.online/state';
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);

    $data = curl_exec($curl);

    curl_close($curl);
    echo "Tash schedule success";
?>