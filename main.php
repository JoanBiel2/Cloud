<?php
// Base de dades simulada d'armes (en format JSON)
// Simular parámetros de URL
$_GET['força'] = 5;
$_GET['destresa'] = 99;

$armes_json = '[
    {"nom": "Misericorde", "frz": 7, "dx": 12, "int": 0, "escfrz": 'E', "escdx": 'C', "escint":'E', "mal": 92},
    {"nom": "Broadsword", "frz": 10, "dx": 10, "int": 0, "escfrz": 'D', "escdx": 'E', "escint":'E', "mal": 117},
    {"nom": "Iron Greatsword", "frz": 18, "dx": 10, "int": 0, "escfrz": 'C', "escdx": 'E', "escint":'E', "mal": 149},
    {"nom": "Greatsword", "frz": 31, "dx": 12, "int": 0, "escfrz": 'C', "escdx": 'E', "escint":'E', "mal": 164},
    {"nom": "Cleanrot Knight's Sword", "frz": 11, "dx": 13, "int": 17, "escfrz": 'D', "escdx": 'D', "escint":'C', "mal": 109},
    {"nom": "Sword Lance", "frz": 21, "dx": 11, "int": 0, "escfrz": 'C', "escdx": 'E', "escint":'E', "mal": 132},
    {"nom": "Wing of Astel", "frz": 7, "dx": 17, "int": 20, "escfrz": 'E', "escdx": 'D', "escint":'D', "mal": 143},
    {"nom": "Bloodhound's Fang", "frz": 18, "dx": 17, "int": 0, "escfrz": 'D', "escdx": 'C', "escint":'E', "mal": 141},
    {"nom": "Moonveil", "frz": 12, "dx": 18, "int": 0, "escfrz": 'E', "escdx": 'D', "escint":'E', "mal": 92},
    {"nom": "Misericorde", "frz": 7, "dx": 12, "int": 0, "escfrz": 'E', "escdx": 'D', "escint":'E', "mal": 92},
    {"nom": "Misericorde", "frz": 7, "dx": 12, "int": 0, "escfrz": 'E', "escdx": 'D', "escint":'E', "mal": 92},
    {"nom": "Misericorde", "frz": 7, "dx": 12, "int": 0, "escfrz": 'E', "escdx": 'D', "escint":'E', "mal": 92},
]';

// Convertir JSON a array
$armes = json_decode($armes_json, true);

// Verificar si s'han enviat els paràmetres necessaris
if (isset($_GET['força']) && isset($_GET['destresa'])) {
    $força = intval($_GET['força']);
    $destresa = intval($_GET['destresa']);

    $arma_recomanada = null;
    $max_puntuacio = 0;

    // Calcular la millor arma basada en els atributs
    foreach ($armes as $arma) {
        $puntuacio = 0;
        if ($força >= $arma["força"]) $puntuacio += 1;
        if ($destresa >= $arma["destresa"]) $puntuacio += 1;

        if ($puntuacio > $max_puntuacio) {
            $max_puntuacio = $puntuacio;
            $arma_recomanada = $arma;
        }
    }

    // Mostrar la imatge de l'arma recomanada
    if ($arma_recomanada) {
        header('Content-Type: text/html'); // Canviem a HTML per mostrar la imatge
        echo '<img src="' . $arma_recomanada['imatge'] . '" alt="' . $arma_recomanada['nom'] . '">';
    } else {
        header('Content-Type: text/plain');
        echo 'No s\'ha trobat una arma adequada.';
    }
} else {
    // Si no s'envien els paràmetres, mostrar un missatge d'error
    header('Content-Type: text/plain');
    echo 'Falten paràmetres. Has d\'enviar "força" i "destresa".';
}
