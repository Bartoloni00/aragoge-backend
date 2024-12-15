<?php
// Todos los archivos de config deben retornar un array asociativo con los valores que queremos hacer disponibles en la app.
// Accedemos a estos valores con la funcion config()
return [
    'publicKey' => env('MP_PUBLIC_KEY'),
    'accessToken' => env('MP_ACCESS_TOKEN'),
];