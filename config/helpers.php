<?php

/**
 * Genera el nombre completo de una propiedad concatenando Galería, Local y Dirección
 */
function getNombrePropiedad($propiedad) {
    $nombre = [];
    
    if (!empty($propiedad['galeria'])) {
        $nombre[] = " " . $propiedad['galeria'];
    }
    
    if (!empty($propiedad['local'])) {
        $nombre[] = " " . $propiedad['local'];
    }
    
    if (!empty($propiedad['direccion'])) {
        $nombre[] = $propiedad['direccion'];
    }
    
    return implode(" - ", $nombre);
} 