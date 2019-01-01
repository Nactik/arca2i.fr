var refBtnEasy;
var refBtnMedium;
var refBtnHard;
var refGamePlate;
var refCtnGamePlate;
var refTimer;
var plateX;
var plateY;
var nbBombs;
var nbCells;
var gameData = new Array();
var plateCells = new Array();
var time;
var milliseconds;
var seconds;
var minutes;
var hours;
var timeString;
var difficulty;

function init () {
  refBtnEasy = document.getElementsByName("esay");
  refBtnMedium = document.getElementsByName("medium");
  refBtnHard =  document.getElementsByName("hard");
  refCtnGamePlate = document.getElementById("containerGamePlate");
  refTimer = document.getElementById("countainerTimer");
}

function newGame(element) {
  refCtnGamePlate.innerHTML = "<table id = 'gamePlate'>"
        + "<tbody>"
        + "</tbody>"
      + "</table> "
  refGamePlate = document.getElementById("gamePlate");
  mkTable(element);
  milliseconds = 0;
  seconds = 0;
  minutes = 0;
  hours = 0;
  time = window.setInterval(timer, 10);
}

function mkTable (element) {
  switch (element.name) {
    case "easy":
      difficulty = "EAS";
      plateX = 12; //8
      plateY = 12; //12
      nbBombs = 15;
      break;
    case "medium":
      difficulty = "MID";
      plateX = 16;
      plateY = 16;
      nbBombs = 60  ;
      break;
    case "hard":
      difficulty = "HAR";
      plateX = 24;
      plateY = 24;
      nbBombs = 230;
      break;
    default:
      plateX = 0;
      plateY = 0;
  }
  nbCells = plateX * plateY;
  for (var i = 0; i < nbCells; i++) {
    gameData[i] = 0;
  }

  for (var i = 0; i < nbBombs; i++) {
    do{
      var rand = Math.random()* nbCells;
      rand = rand - rand%1;
    } while(gameData[rand] == 1)
      gameData[rand] = 1;
  }
  var chaine ="";
  for(var i = 0; i < plateY; i++) {
    chaine += "<tr> ";
    for(var j = 0; j < plateX; j++) {
        chaine += "<td id=" +  ((plateX)*i+j) + " class='unknownCells' onclick='checkBomb(this.id, true);'></td> ";
    }
    chaine += "</tr>";
  }
  refGamePlate.innerHTML = chaine;
  for (var i = 0; i < nbCells; i++) {
    plateCells[i] = document.getElementById(i);
  }
  //demineMoiTout();
}

function demineMoiTout() {
  for (var i = 0; i < nbCells; i++) {
    switch (gameData[i]) {
      case 1:
        plateCells[i].className = "trapedCells";
        break;
      /*case 0:
        plateCells[i].className = "safeCells";
        break;*/
      default:
        break;
    }
  }
}

function checkBomb(id, first = false) {
  switch (gameData[id]) {
    case 1:
      if (first) {
        endGame(timeString, false);
        plateCells[id].className = "trapedCells";
      }
      break;
    case 0:
      plateCells[id].className = "safeCells";
      gameData[id] = 2; // --> known & safe cell
      checkOtherBombs(id);
      break;
    default:
      break;
  }
  countCells();
}

function checkOtherBombs(id) {
  countBombs(id, "HD");
  if (id == plateX-1) {  // coin haut droit
    if(gameData[parseInt(id)+plateX] != 1 && gameData[parseInt(id)-1] != 1 && gameData[parseInt(id)+plateX -1] != 1) {
      checkBomb(parseInt(id)+plateX);       // BAS
      checkBomb(parseInt(id)-1);            // GAUCHE
    }
  }
  else if (id == 0 ) {  // coin haut gauche
    countBombs(id, "HG");
    if(gameData[parseInt(id)+1] != 1 && gameData[parseInt(id)+plateX] != 1 && gameData[parseInt(id)+plateX+1] != 1) {
      checkBomb(parseInt(id)+1);            // DROITE
      checkBomb(parseInt(id)+plateX);       // BAS
    }
  }
  else if (id  == nbCells-1 ) {  // coin bas droit
    countBombs(id, "BD");
    if(gameData[parseInt(id)-1] != 1 && gameData[parseInt(id)-plateX] != 1 && gameData[parseInt(id)-plateX-1] != 1) {
      checkBomb(parseInt(id)-1);            // GAUCHE
      checkBomb(parseInt(id)-plateX);       // HAUT
    }
  }
  else if (id == plateX*(plateY - 1) ) {  // coin bas gauche
    countBombs(id, "BG");
    if(gameData[parseInt(id)-plateX] != 1 && gameData[parseInt(id)+1] != 1 && gameData[parseInt(id)-plateX+1] != 1) {
      checkBomb(parseInt(id)-plateX);       // HAUT
      checkBomb(parseInt(id)+1);            // DROITE
    }
  }
  else if (id < plateX) {  // Ligne haut
    countBombs(id, "H");
    if(gameData[parseInt(id)+1] != 1 && gameData[parseInt(id)+plateX] != 1 && gameData[parseInt(id)-1] != 1 && gameData[parseInt(id)+plateX+1] != 1 && gameData[parseInt(id)+plateX-1] != 1) {
      checkBomb(parseInt(id)+1);            // DROITE
      checkBomb(parseInt(id)+plateX);       // BAS
      checkBomb(parseInt(id)-1);            // GAUCHE
    }
  }
  else if (id > plateX * (plateY-1)-1) {  // Ligne bas
    countBombs(id, "B");
    if(gameData[parseInt(id)-plateX] != 1 && gameData[parseInt(id)+1] != 1 && gameData[parseInt(id)-1] != 1 && gameData[parseInt(id)-plateX+1] != 1 && gameData[parseInt(id)-plateX-1] != 1) {
      checkBomb(parseInt(id)-plateX);       // HAUT
      checkBomb(parseInt(id)+1);            // DROITE
      checkBomb(parseInt(id)-1);            // GAUCHE
    }
  }
  else if (id % plateX == 0) {  // colonne gauche
    countBombs(id, "G");
    if(gameData[parseInt(id)-plateX] != 1 && gameData[parseInt(id)+1] != 1 && gameData[parseInt(id)+plateX] != 1 && gameData[parseInt(id)+plateX+1] != 1 && gameData[parseInt(id)-plateX+1] != 1) {
      checkBomb(parseInt(id)-plateX);       // HAUT
      checkBomb(parseInt(id)+1);            // DROITE
      checkBomb(parseInt(id)+plateX);       // BAS
    }
  }
  else if ((parseInt(id)+1) % plateX == 0) {  // colonne droite
    countBombs(id, "D");
    if(gameData[parseInt(id)-plateX] != 1 && gameData[parseInt(id)+plateX] != 1 && gameData[parseInt(id)-1] != 1 && gameData[parseInt(id)-plateX-1] != 1 && gameData[parseInt(id)+plateX-1] != 1) {
      checkBomb(parseInt(id)-plateX);       // HAUT
      checkBomb(parseInt(id)+plateX);       // BAS
      checkBomb(parseInt(id)-1);            // GAUCHE
    }
  }
  else {
    countBombs(id);
    if(gameData[parseInt(id)-plateX] != 1 && gameData[parseInt(id)+1] != 1 && gameData[parseInt(id)+plateX] != 1 && gameData[parseInt(id)-1] != 1 && gameData[parseInt(id)+plateX+1] != 1 && gameData[parseInt(id)+plateX-1] != 1 && gameData[parseInt(id)-plateX-1] != 1 && gameData[parseInt(id)-plateX+1] != 1) {
      checkBomb(parseInt(id)-plateX);       // HAUT
      checkBomb(parseInt(id)+1);            // DROITE
      checkBomb(parseInt(id)+plateX);       // BAS
      checkBomb(parseInt(id)-1);            // GAUCHE
    }
  }
}

function countBombs(id, position) {
  var countBombs = 0;
  switch (position) {
    case "HD":
      if (gameData[parseInt(id)+plateX] == 1) {         // BAS
        countBombs += 1;
      }
      if (gameData[parseInt(id)-1] == 1) {              // GAUCHE
        countBombs += 1;
      }
      if (gameData[parseInt(id)+plateX-1] == 1) {       // BAS GAUCHE
        countBombs += 1;
      }
      break;
    case "HG":
      if (gameData[parseInt(id)+1] == 1) {              // DROITE
        countBombs += 1;
      }
      if (gameData[parseInt(id)+plateX] == 1) {         // BAS
        countBombs += 1;
      }
      if (gameData[parseInt(id)+plateX+1] == 1) {       // BAS DROITE
        countBombs += 1;
      }
      break;
    case "BD":
      if (gameData[parseInt(id)-plateX] == 1) {         // HAUT
        countBombs += 1;
      }
      if (gameData[parseInt(id)-1] == 1) {              // GAUCHE
        countBombs += 1;
      }
      if (gameData[parseInt(id)-plateX-1] == 1) {       // HAUT GAUCHE
        countBombs += 1;
      }
      break;
    case "BG":
      if (gameData[parseInt(id)-plateX] == 1) {         // HAUT
        countBombs += 1;
      }
      if (gameData[parseInt(id)+1] == 1) {              // DROITE
        countBombs += 1;
      }
      if (gameData[parseInt(id)-plateX+1] == 1) {       // HAUT DROITE
        countBombs += 1;
      }
      break;
    case "H":
      if (gameData[parseInt(id)+1] == 1) {              // DROITE
        countBombs += 1;
      }
      if (gameData[parseInt(id)+plateX] == 1) {         // BAS
        countBombs += 1;
      }
      if (gameData[parseInt(id)-1] == 1) {              // GAUCHE
        countBombs += 1;
      }
      if (gameData[parseInt(id)+plateX+1] == 1) {       // BAS DROITE
        countBombs += 1;
      }
      if (gameData[parseInt(id)+plateX-1] == 1) {       // BAS GAUCHE
        countBombs += 1;
      }
      break;
    case "B":
      if (gameData[parseInt(id)-plateX] == 1) {         // HAUT
        countBombs += 1;
      }
      if (gameData[parseInt(id)+1] == 1) {              // DROITE
        countBombs += 1;
      }
      if (gameData[parseInt(id)-1] == 1) {              // GAUCHE
        countBombs += 1;
      }
      if (gameData[parseInt(id)-plateX-1] == 1) {       // HAUT GAUCHE
        countBombs += 1;
      }
      if (gameData[parseInt(id)-plateX+1] == 1) {       // HAUT DROITE
        countBombs += 1;
      }
      break;
    case "D":
      if (gameData[parseInt(id)-plateX] == 1) {         // HAUT
        countBombs += 1;
      }
      if (gameData[parseInt(id)+plateX] == 1) {         // BAS
        countBombs += 1;
      }
      if (gameData[parseInt(id)-1] == 1) {              // GAUCHE
        countBombs += 1;
      }
      if (gameData[parseInt(id)+plateX-1] == 1) {       // BAS GAUCHE
        countBombs += 1;
      }
      if (gameData[parseInt(id)-plateX-1] == 1) {       // HAUT GAUCHE
        countBombs += 1;
      }
      break;
    case "G":
      if (gameData[parseInt(id)-plateX] == 1) {         // HAUT
        countBombs += 1;
      }
      if (gameData[parseInt(id)+1] == 1) {              // DROITE
        countBombs += 1;
      }
      if (gameData[parseInt(id)+plateX] == 1) {         // BAS
        countBombs += 1;
      }
      if (gameData[parseInt(id)+plateX+1] == 1) {       // BAS DROITE
        countBombs += 1;
      }
      if (gameData[parseInt(id)-plateX+1] == 1) {       // HAUT DROITE
        countBombs += 1;
      }
      break;
    default:
    if (gameData[parseInt(id)-plateX] == 1) {         // HAUT
      countBombs += 1;
    }
    if (gameData[parseInt(id)+1] == 1) {              // DROITE
      countBombs += 1;
    }
    if (gameData[parseInt(id)+plateX] == 1) {         // BAS
      countBombs += 1;
    }
    if (gameData[parseInt(id)-1] == 1) {              // GAUCHE
      countBombs += 1;
    }
    if (gameData[parseInt(id)+plateX+1] == 1) {       // BAS DROITE
      countBombs += 1;
    }
    if (gameData[parseInt(id)+plateX-1] == 1) {       // BAS GAUCHE
      countBombs += 1;
    }
    if (gameData[parseInt(id)-plateX-1] == 1) {       // HAUT GAUCHE
      countBombs += 1;
    }
    if (gameData[parseInt(id)-plateX+1] == 1) {       // HAUT DROITE
      countBombs += 1;
    }
  }
  if (countBombs != 0) {
    plateCells[id].innerHTML = countBombs;
  }
}

function countCells() {
  var nbCellsUkw = 0;
  for(var i = 0; i < nbCells; i++) {
    if (gameData[i] == 0) nbCellsUkw += 1;
  }
  if (nbCellsUkw == 0) {
    endGame(timeString);
  }
}

function timer() {
  timeString = "";
  milliseconds += 1;
  if (milliseconds == 100) {
    milliseconds = 0;
    seconds += 1;
  }
  if (seconds == 60) {
    seconds = 0;
    minutes += 1;
  }
  if (minutes == 60) {
    minutes = 0;
    hours += 1;
  }
  if(hours > 0) timeString += hours + " : ";
  if (minutes < 10) {
    timeString += "0" + minutes + " : ";
  }
  else {
    timeString += minutes + " : ";
  }
  if (seconds < 10) {
    timeString += "0" + seconds + " : ";
  }
  else {
    timeString += seconds + " : ";
  }
  if (milliseconds < 10) {
    timeString += "0" + milliseconds;
  }
  else {
    timeString += milliseconds;
  }
  refTimer.className = "timerStyle";
  refTimer.innerHTML = "<span>" + timeString + "</span>";
}

function parseScore(score){
    //parsedString = score.replace(/\s:\s/,'');
    parsedString = score.split(" : ").join("");
    //parsedScore = parseInt(parsedString);
    return parsedString;
}

function uploadHighScore(score) {
  var url = "controleur.php?action=upload&score="+finalScore+"&game=3&difficulty="+difficulty;
  window.location.replace(url);
}

function endGame(score, victory = true) {

  if (victory) {
    refCtnGamePlate.innerHTML = "<p style='color: tomato; font-size: 25px;' > Partie terminée ! " +"Bravo à toi ! :) <br /> Ton temps est " + score + "</p>";
    finalScore = parseScore(score);
    console.log(finalScore);
    uploadHighScore(finalScore,difficulty);
  }
  else {
    refCtnGamePlate.innerHTML = "<p style='color: tomato; font-size: 25px;' > Partie terminée ! " +"Dommage, tu y étais presque ! Essaye encore ! ;) </p>";
  }
  window.clearInterval(time);
  refTimer.innerHTML = "";
  refTimer.className = "";
  
}
