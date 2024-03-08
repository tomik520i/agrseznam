<?php

$jmena = "";
$body = "";
$cas = "";
$description = "";
$title = "";

if (array_key_exists("odeslat", $_POST)) {
  $body = $_POST["body"];
  $jmena = $_POST["jmena"];
  $description = $_POST["description"];
  $title = $_POST["title"];
  $cas = $_POST["cas"];
}

?>
<!DOCTYPE html>
<html lang="cs">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>agrE</title>

  <link rel="icon" type="image/x-icon" href="favicon">

  <link href="./fontawesome/css/all.min.css" rel="stylesheet" />
</head>

<body>
  <?php

  if (array_key_exists("odeslat", $_POST)) {

    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => "https://wheelofnames.com/api/wheels/shared",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $body,
      CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "x-api-key: "
      ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      $response;
    }
  }

  ?>

  <div>
    <h1>Sem nakopíruj seznam</h1>
    <form method="post" id="form">
      <textarea name="jmena" id="textarea" cols="50" rows="30"><?php echo $jmena ?></textarea>
  </div>
  <div class="nastaveni">
    <h1>Nastavení</h1>
    <h4>nemusí se vyplňovat</h4>
    Title: <input type="text" id="title" name="title" value="<?php echo $title ?>">
    Description: <input type="text" id="description" name="description" value="<?php echo $description ?>">
    Čas točky: (v sekundách)<input type="number" id="cas" name="cas" value="<?php echo $cas ?>">
  </div>
  <div class="seznam">
    <textarea name="body" id="body" cols="30" rows="10"></textarea>
    <button id="odeslat" name="odeslat" class="button">Vygenerovat kolo</button>
    </form>

    <div id="odkaz">

    </div>

    <div id="seznam">
      <?php
      echo str_replace(";", "<br>", $jmena);
      ?>
    </div>
  </div>

  <script>
    const textarea = document.getElementById("textarea")
    const zobrazeni = document.getElementById("seznam")

    const tlacitko = document.getElementById("odeslat")

    const title2 = document.getElementById("title")
    const description2 = document.getElementById("description")
    const cas2 = document.getElementById("cas")

    let pole = [];
    let cas = 10;
    let description = "agrE";
    let title = "agrE";

    function myFunction() {
            const body2 = document.getElementById("body")
      
            let body = `{"wheelConfig":{"description":"${description}","title":"${title}","spinTime":${cas},"launchConfetti":true, "entries":${JSON.stringify(pole)}},"shareMode":"gallery"}`
      
            body2.value = body;
    }

    title2.addEventListener("input", (udalost) => {
      console.log(title2.value)

      if (title2.value == "") {
        title = "agrE"

        myFunction()
      } else {
        title = title2.value

        myFunction()
      }
    })

    description2.addEventListener("input", (udalost) => {
      console.log(description2.value)

      if (description2.value == "") {
        description = "agrE"

        myFunction()
      } else {
        description = description2.value

        myFunction()
      }
    })

    cas2.addEventListener("input", (udalost) => {
      console.log(cas2.value)

      if (cas2.value == "") {
        cas = 10

        myFunction()
      } else {
        cas = cas2.value

        myFunction()
      }
    })

    textarea.addEventListener("input", (udalost) => {

      value = textarea.value

      value2 = value.replaceAll(";", "<br>")
      value3 = value2.trim();

      pole = [];

      jmena = value3.split('<br>');

      jmena2 = [];

      jmena.forEach((jmeno, index) => {

        jmeno = jmeno.trim();

        jmena2.push(jmeno);
      })

      jmena = jmena2.filter((word) => word.length > 2);

      zobrazeni.innerHTML = value2;

      let stoprocent = jmena.length;

      procentojmena = (1 / stoprocent) * 100

      jmena.forEach((jmeno, index) => {
        let randomBetween = (min, max) => min + Math.floor(Math.random() * (max - min + 1));
        let r = randomBetween(0, 255);
        let g = randomBetween(0, 255);
        let b = randomBetween(0, 255);

        pole2 = {
          "text": `${jmeno}`,
          "color": `rgb(${r},${g},${b})`,
          "weight": Math.round(procentojmena)
        }

        pole.push(pole2);
      });

      myFunction()

    })
  </script>

  <?php
  if (array_key_exists("odeslat", $_POST)) {
  ?>

    <script>
      const odkaz = document.getElementById("odkaz");
      const odkaz2 = <?php echo $response ?>;
      odkaz.innerHTML = `<a href='https://wheelofnames.com/en/${odkaz2.data.path}' target='_blank' >Sem klikni troubo</a><br><span id="myText" class='link'>https://wheelofnames.com/en/${odkaz2.data.path}</span> <button class="button2" onclick="copyContent()"><i class="fa-regular fa-copy"></i></button>`;
      let text = document.getElementById('myText').innerHTML;
      const copyContent = async () => {
        try {
          await navigator.clipboard.writeText(text);
          console.log('Content copied to clipboard');
        } catch (err) {
          console.error('Failed to copy: ', err);
        }
      }
    </script>

  <?php
  }
  ?>

  <style>
    body {
      display: flex;
      justify-content: space-evenly;
      background-image: url("maxresdefault.jpg");
      background-size: cover;
      background-position: center;
      text-shadow: 1px 1px 4px white;
    }

    textarea {
      background-color: rgba(255, 255, 255, 0.581);
      border: 1px solid black;
    }

    h1 {
      text-align: center;
    }

    .button {
      background-color: #000000;
      border: none;
      color: white;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      cursor: pointer;
    }

    .button2 {
      border: none;
      background-color: #ffffff00;
      font-size: 22px;
      cursor: pointer;
    }

    .button2:hover {
      color: darkblue;
    }

    .button,
    .button2 {
      transition-duration: 0.4s;
    }

    .button:hover {
      background-color: #ffffff;
      color: rgb(0, 0, 0);
    }

    .seznam {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    #odkaz {
      width: 100%;
      padding: 10px;
      text-align: center;
    }

    #odkaz a {
      text-decoration: none;
      color: black;
      font-size: 30px;
      text-align: center;
    }

    #odkaz a:hover {
      color: darkblue;
    }

    #body {
      display: none;
    }

    .link {
      font-size: 25px;
    }

    .nastaveni {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .nastaveni input {
      margin: 5px;
    }

    .nastaveni h1,
    h4 {
      margin: 10px;
    }
  </style>
</body>

</html>