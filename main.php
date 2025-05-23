<?php
// Base de dades simulada d'armes (en format JSON)

//{
//"name": "Recomenador d'armes Elden Ring",
//"url": "https://eldenringcalculardanyo-gahqhke4bff9a3f6.westeurope-01.azurewebsites.net/main.php?frz=0&dx=0&int=0&fe=99&arc=0",
//"description": "Recomana l'arma que mes mal fagui amb les estadistiques que te el jugador. L'usuari ha d'inserir la seva Força (frz), Destresa (dx), i Intel·ligencia(int) per que la func>
//"authors": ["Arnau Barba", "Joan Biel"]
//}

// Llegir les armes des d'un fitxer CSV
$armes = [];
$fitxer = fopen("list.csv", "r");

if ($fitxer !== false) {
    fgetcsv($fitxer); // Saltar l'encapçalament

    while (($fila = fgetcsv($fitxer)) !== false) {
        $armes[] = [
            "nom" => $fila[0],
            "frz" => intval(trim($fila[12]) ?: 0),
            "dx" => intval(trim($fila[13]) ?: 0),
            "int" => intval(trim($fila[14]) ?: 0),
            "fe" => intval(trim($fila[15]) ?: 0),
            "arc" => intval(trim($fila[16]) ?: 0),
            "escfrz" => $fila[5],
            "escdx" => $fila[6],
            "escint" => $fila[7],
            "escfe" => $fila[8],
            "escarc" => $fila[9],
            "mal" => intval($fila[2])
        ];
    }
    fclose($fitxer);
} else {
    die("No s'ha pogut llegir el fitxer d'armes.");
}

// Verificar si s'han enviat els paràmetres necessaris
if (isset($_GET['frz']) && isset($_GET['dx']) && isset($_GET['int']) && isset($_GET['fe']) && isset($_GET['arc'])) {
    $frz = intval($_GET['frz']);
    $dx = intval($_GET['dx']);
    $int = intval($_GET['int']);
    $fe  = intval($_GET['fe']);
    $arc = intval($_GET['arc']);

    if ($frz > 99 || $dx > 99 || $int > 99 || $fe > 99 || $arc > 99) {
        echo "Les dades han de ser entre 0 i 99.\n";
    } else {
        $arma_recomanada = null;
        $max_puntuacio = 0;

        foreach ($armes as $arma) {
            $puntuacio = $arma["mal"];

            if (
                $frz < $arma["frz"] ||
                $dx < $arma["dx"] ||
                $int < $arma["int"] ||
                $fe < $arma["fe"] ||
                $arc < $arma["arc"]
            ) {
                continue;
            }

            // Escalat per atributs
            $atributs = [
                "frz" => $frz,
                "dx" => $dx,
                "int" => $int,
                "fe" => $fe,
                "arc" => $arc
            ];
            $escalats = [
                "frz" => "escfrz",
                "dx" => "escdx",
                "int" => "escint",
                "fe" => "escfe",
                "arc" => "escarc"
            ];

            foreach ($atributs as $key => $valor) {
              $escala = isset($arma[$escalats[$key]]) ? strtoupper(trim($arma[$escalats[$key]])) : ""; // Vacíos tratados como cadena vacía


                if ($valor <= 50) {
                    $puntuacio += match ($escala) {
                        "E" => 3,
                        "D" => 5,
                        "C" => 10,
                        "B" => 20,
                        "A" => 30,
                        "S" => 40,
                        default => 0
                    };
                } else {
                    $puntuacio += match ($escala) {
                        "E" => 10,
                        "D" => 15,
                        "C" => 20,
                        "B" => 30,
                        "A" => 40,
                        "S" => 50,
                        default => 0
                    };
                }
            }

            if ($puntuacio > $max_puntuacio) {
                $max_puntuacio = $puntuacio;
                $arma_recomanada = $arma;
            }
        }

        // Mostrar el resultat
        if ($arma_recomanada) {
            echo "La millor arma amb aquestes estadístiques és: " . $arma_recomanada["nom"] . ".\n";
            echo "Dany total: " . $max_puntuacio;
        } else {
            header('Content-Type: text/plain');
            echo "No s'ha trobat una arma adequada.\n";
        }
    }
} else {
    header('Content-Type: text/plain');
    echo "Falten paràmetres. Has d'enviar 'frz', 'dx', 'int', 'fe' i 'arc'.\n";
}
?>


