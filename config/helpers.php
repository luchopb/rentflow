<?php

/**
 * Genera el nombre completo de una propiedad concatenando Galería, Local y Dirección
 */
function getNombrePropiedad($propiedad) {
    $nombre = [];
    
    if (!empty($propiedad['galeria'])) {
        $nombre[] = "Galería " . $propiedad['galeria'];
    }
    
    if (!empty($propiedad['local'])) {
        $nombre[] = "Local " . $propiedad['local'];
    }
    
    if (!empty($propiedad['direccion'])) {
        $nombre[] = $propiedad['direccion'];
    }
    
    return implode(" - ", $nombre);
} 