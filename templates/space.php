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



        $result = listerHighScores('2','EAS');
        echo '<div id="tabScore">';
        echo "<table>";
        echo " <tr><th> Pseudo </th> <th> Score </th></tr>";
        foreach($result  as $R=>$D){
         echo "<tr id='Tr_".$R."'>"; 
         foreach($D as $key=>$Value){
            echo "<td id='Td_".$R."_".$key."'>".$Value."</td>";
          }
         echo "</tr>";
        }
        echo "</table>";
        echo"</div>";
  ?>

    <div id="game">
    </div><!-- #game -->
    <h1 id='invaders'>INVADERS</h1>
    <footer>Made by <a href="http://danbarber.me">Dan Barber</a> with <a href="http://phaser.io">Phaser</a></footer>

    <script src="js/phaser2.min.js" type="text/javascript"></script>
    <script src="js/cookies.min.js" type="text/javascript"></script>
    <script src="js/preload.js" type="text/javascript"></script>
    <script src="js/create.js" type="text/javascript"></script>
    <script src="js/update.js" type="text/javascript"></script>
    <script src="js/game.js" type="text/javascript"></script>

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-603600-6', 'danbarber.me');
      ga('send', 'pageview');
    </script>

  </body>
</html>