<?php

$jmena = "";
$body = "";

if (array_key_exists("odeslat", $_POST)) {
  $body = $_POST["body"];
  $jmena = $_POST["jmena"];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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
    <form method="post">
      <textarea name="jmena" id="textarea" cols="50" rows="30"><?php echo $jmena ?></textarea>
  </div>
  <div class="seznam">
    <textarea name="body" id="body" cols="30" rows="10"></textarea>
    <button id="copy" name="odeslat">Vygenerovat kolo</button>
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
    const tlacitko = document.getElementById("copy")

    const title = "agrE"
    const description = "agrE"

    textarea.addEventListener("input", (udalost) => {

      value = textarea.value

      value2 = value.replaceAll(";", "<br>")
      value3 = value2.trim();
      //value3 = value3.replaceAll(" ", "")

      jmena = value3.split('<br>');

      //console.log(jmena);

      jmena2 = [];

      jmena.forEach((jmeno, index) => {

        //console.log(jmeno);

        jmeno = jmeno.trim();

        //console.log(jmeno);

        jmena2.push(jmeno);
      })

      jmena = jmena2.filter((word) => word.length > 2);

      //console.log(jmena);

      zobrazeni.innerHTML = value2;

      const pole = [];

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

      const body2 = document.getElementById("body")

      let body = `{"wheelConfig":{"description":"${title}","title":"${description}","launchConfetti":true, "entries":${JSON.stringify(pole)}},"shareMode":"gallery"}`

      body2.value = body;

    })
  </script>

  <?php
  if (array_key_exists("odeslat", $_POST)) {
  ?>

    <script>
      const odkaz = document.getElementById("odkaz");
      const odkaz2 = <?php echo $response ?>;
      console.log(odkaz2);
      odkaz.innerHTML = `<a href='https://wheelofnames.com/en/${odkaz2.data.path}' target='_blank' >Sem klikni troubo</a>`;
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
    }

    textarea {
      background-color: rgba(255, 255, 255, 0.581);
      border: 1px solid black;
    }

    h1 {
      text-align: center;
    }

    button {
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

    button {
      transition-duration: 0.4s;
    }

    button:hover {
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
  </style>
</body>

</html>