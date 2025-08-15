<?php
// URL de la webcam en Skyline
$webcam_url = "https://www.skylinewebcams.com/es/webcam/espana/region-de-murcia/murcia/manga-mar-menor-cartagena.html";

// Configuración del contexto HTTP para simular un navegador
$opts = [
    "http" => [
        "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) ".
                    "AppleWebKit/537.36 (KHTML, like Gecko) ".
                    "Chrome/115.0 Safari/537.36\r\n"
    ]
];
$context = stream_context_create($opts);

// Descargamos el HTML de la página
$html = file_get_contents($webcam_url, false, $context);

// Buscamos el enlace .m3u8 con token usando regex
if (preg_match('/https?:\/\/[^"\']+\.m3u8[^"\']*/', $html, $matches)) {
    $m3u8_url = $matches[0];

    // Configuración de las cabeceras para el stream
    header("Content-Type: application/vnd.apple.mpegurl");
    header("Location: " . $m3u8_url);
    exit;
} else {
    header("HTTP/1.1 500 Internal Server Error");
    echo "No se pudo encontrar el enlace de la transmisión.";
}
?>
