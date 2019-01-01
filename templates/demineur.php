    <?php 
        //C'est la propriété php_self qui nous l'indique : 
        // Quand on vient de index : 
        // [PHP_SELF] => /chatISIG/index.php 
        // Quand on vient directement par le répertoire templates
        // [PHP_SELF] => /chatISIG/templates/accueil.php

        // Si la page est appelée directement par son adresse, on redirige en passant pas la page index
        // Pas de soucis de bufferisation, puisque c'est dans le cas où on appelle directement la page sans son contexte
        if (basename($_SERVER["PHP_SELF"]) != "index.php")
        {
            header("Location:../index.php?view=accueil");
            die("");
        }

        include("libs/modele.php");
    ?>
    
    <!-- GAME SCREEN -->
    <div class="buttons">
      <button type="button" class="buttonDem"  name="easy" onclick="newGame(this);"> Facile </button>
      <button type="button" class="buttonDem" name="medium" onclick="newGame(this);"> Expérimenté </button>
      <button type="button" class="buttonDem" name="hard" onclick="newGame(this);"> Dément </button>
    </div>
    <div id="countainerTimer"> </div>
    <div id="gameScreen">
      <div id="containerGamePlate">
          <p style="color: tomato; font-size: 25px;" > Choisissez une difficulté pour jouer ! :) </p>
      </div>
    </div>

    <?php   
      $result2 = listerHighScoresDem();
      echo '<div id="tabScore">';
      echo "<table>";
      echo " <tr><th> Pseudo </th>  <th> Difficulty </th><th> Score </th></tr>";
      foreach($result2  as $R=>$D){
          echo "<tr id='Tr_".$R."'>"; 
          foreach($D as $key=>$Value){
              echo "<td id='Td_".$R."_".$key."'>".$Value."</td>";
          }
          echo "</tr>";
      }
      echo "</table>";
      echo"</div>";
    ?>
  </body>
</html>
