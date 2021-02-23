// Especifica lo que se debe pintar al cargar el juego
var startGame = function () {
  var board = new GameBoard();
  board.add(new froggerLogo());
  board.add(new TitleScreen("",
  "Press enter to start playing",
  playGame))
  Game.setBoard(0, board );
}



var playGame = function () {


  var board = new GameBoard();

  board.add(new Escenario());
  board.add(new Water());
  board.add(new Grass());
  
  //board.add(new Level(level1,winGame));
  board.add(new Spawn(winGame));
  
  board.add(new PlayerFrog());
  Game.setBoard(1, board);
  Game.setBoard(2,null);
  //Game.setBoard(0,null);

}

var winGame = function () {
  Game.setBoard(2, new TitleScreen("You win!",
    "Press enter to play again",
    playGame));
};



var loseGame = function () {
  Game.setBoard(2, new TitleScreen("You lose!",
    "Press enter to play again",
    playGame));
};


// Indica que se llame al método de inicialización una vez
// se haya terminado de cargar la página HTML
// y este después de realizar la inicialización llamará a
// startGame
window.addEventListener("load", function () {
  Game.initialize("game", sprites, startGame);
});