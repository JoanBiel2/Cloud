<?php
// Base de dades simulada d'armes (en format JSON)

//{
//"name": "Recomenador d'armes Elden Ring",
//"url": "http://localhost/main.php?frz=15&dx=12&int=15",
//"description": "Recomana l'arma que mes mal fagui amb les estadistiques que te el jugador. L'usuari ha d'inserir la seva Força (frz), Destresa (dx), i Intel·ligencia(int) per que la func>
//"authors": ["Arnau Barba", "Joan Biel"]
//}


$armes_json = '[
    {"nom": "Misericorde", "frz": 7, "dx": 12, "int": 0, "escfrz": "E", "escdx": "C", "escint": "E", "mal": 92},
    {"nom": "Broadsword", "frz": 10, "dx": 10, "int": 0, "escfrz": "D", "escdx": "E", "escint": "E", "mal": 117},
    {"nom": "Iron Greatsword", "frz": 18, "dx": 10, "int": 0, "escfrz": "C", "escdx": "E", "escint":"E", "mal": 149},
    {"nom": "Greatsword", "frz": 31, "dx": 12, "int": 0, "escfrz": "C", "escdx": "E", "escint":"E", "mal": 164},
    {"nom": "Cleanrot Knights Sword", "frz": 11, "dx": 13, "int": 17, "escfrz": "D", "escdx": "D", "escint":"C", "mal": 109},
    {"nom": "Sword Lance", "frz": 21, "dx": 11, "int": 0, "escfrz": "C", "escdx": "E", "escint":"E", "mal": 132},
    {"nom": "Wing of Astel", "frz": 7, "dx": 17, "int": 20, "escfrz": "E", "escdx": "D", "escint":"D", "mal": 143},
    {"nom": "Bloodhounds Fang", "frz": 18, "dx": 17, "int": 0, "escfrz": "D", "escdx": "C", "escint":"E", "mal": 141},
    {"nom": "Moonveil", "frz": 12, "dx": 18, "int": 23, "escfrz": "E", "escdx": "D", "escint":"C", "mal": 160},
    {"nom": "Twinned Knight Swords", "frz": 16, "dx": 18, "int": 0, "escfrz": "D", "escdx": "E", "escint":"E", "mal": 122},
    {"nom": "Warped Axe", "frz": 24, "dx": 8, "int": 0, "escfrz": "C", "escdx": "E", "escint":"E", "mal": 124},
    {"nom": "Executioners Greataxe", "frz": 34, "dx": 8, "int": 0, "escfrz": "C", "escdx": "E", "escint":"E", "mal": 150}
]';

// Convertir JSON a array
$armes = json_decode($armes_json, true);

// Verificar si s'han enviat els paràmetres necessaris
if (isset($_GET['frz']) && isset($_GET['dx']) && isset($_GET['int'])) {
    $frz= intval($_GET['frz']);
    $dx = intval($_GET['dx']);
    $int = intval($_GET['int']);

    if ($frz > 99 or $dx > 99 or $int > 99) echo "Les dades han de ser etre 0 i 99.\n";

    else {
      $arma_recomanada = null;
      $max_puntuacio = 0;

      // Calcular la millor arma basada en els atributs
      foreach ($armes as $arma) {
        $puntuacio = $arma["mal"];
        if ($frz < $arma["frz"]){}
        elseif ($dx < $arma["dx"]){}
        elseif ($int < $arma["int"]){}

        else {
          if ($frz >= 0 && $frz <= 50){
            if($arma["escfrz"] == "E")  $puntuacio += 3;
            else if ($arma["escfrz"] == "D") $puntuacio += 5;
            else if ($arma["escfrz"] == "C") $puntuacio += 10;

          }
          else {
            if($arma["escfrz"] == "E")  $puntuacio += 10;
            else if ($arma["escfrz"] == "D") $puntuacio += 15;
            else if ($arma["escfrz"] == "C") $puntuacio += 20;
          }

          if ($dx >= 0 && $dx <= 50){
            if($arma["escdx"] == "E")  $puntuacio += 3;
            else if ($arma["escdx"] == "D") $puntuacio += 5;
            else if ($arma["escdx"] == "C") $puntuacio += 10;
          }

          else {
            if($arma["escdx"] == "E")  $puntuacio += 10;
            else if ($arma["escdx"] == "D") $puntuacio += 15;
            else if ($arma["escdx"] == "C") $puntuacio += 20;
          }

          if ($int >= 0 && $int <= 50){
            if($arma["escint"] == "E")  $puntuacio += 3;
            else if ($arma["escint"] == "D") $puntuacio += 5;
            else if ($arma["escint"] == "C") $puntuacio += 10;
          }

          else {
            if($arma["escint"] == "E")  $puntuacio += 10;
            else if ($arma["escint"] == "D") $puntuacio += 15;
            else if ($arma["escint"] == "C") $puntuacio += 20;
          }

          if ($puntuacio > $max_puntuacio) {
            $max_puntuacio = $puntuacio;
            $arma_recomanada = $arma;

          }
       }
      }
    }

    // Mostrar el nom de l'arma recomanada
    if ($arma_recomanada) {
        echo "La millor arma per aquestes estadístiques és: " . $arma_recomanada["nom"].".\n";
    } else {
        header('Content-Type: text/plain');
        echo 'No s\'ha trobat una arma adequada.\n';
    }
} else {
    // Si no s'envien els paràmetres, mostrar un missatge d'error
    header('Content-Type: text/plain');
    echo 'Falten paràmetres. Has d\'enviar "força", "destresa" i "intel·ligència".\n';
