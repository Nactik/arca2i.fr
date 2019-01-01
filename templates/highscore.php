<?php

    // Si la page est appelée directement par son adresse, on redirige en passant pas la page index
    if (basename($_SERVER["PHP_SELF"]) != "index.php")
    {
        header("Location:../index.php");
        die("");
    }

    include("libs/modele.php");

    $result1 = listerHighScores('1','EAS');
    echo '<div class="tabContainer">';
    echo '<h2> Snake </h2>';
    echo '<div id="tabScore">';
    echo "<table>";
    echo " <tr><th> Pseudo </th> <th> Score </th></tr>";
    foreach($result1  as $R=>$D){
        echo "<tr id='Tr_".$R."'>"; 
        foreach($D as $key=>$Value){
            echo "<td id='Td_".$R."_".$key."'>".$Value."</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    echo"</div>";
    echo"</div>";

    $result3 = listerHighScores('2','EAS');
    echo '<div class="tabContainer">';
    echo '<h2> Space Invaders </h2>';
    echo '<div id="tabScore">';
    echo "<table>";
    echo " <tr><th> Pseudo </th> <th> Score </th></tr>";
    foreach($result3  as $R=>$D){
        echo "<tr id='Tr_".$R."'>"; 
        foreach($D as $key=>$Value){
            echo "<td id='Td_".$R."_".$key."'>".$Value."</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    echo"</div>";
    echo"</div>";

    $result2 = listerHighScoresDem();
    echo '<div class="tabContainer">';
    echo '<h2>Démineur </h2>';
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
    echo"</div>";
    


?>


 </body>
</html>