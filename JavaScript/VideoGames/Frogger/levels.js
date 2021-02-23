/*var level1 = [
 // Start,    End, Gap,  Type,   Override
//tipo, carril, sentido, inicio, velocidad,tiempoAux, tiempoEspera, zIndex
  ['logShort', 5, -1, 550, 90, 1, 3, 0], 
  ['logLong', 1, -1, 550, 60, 1, 6, 1],
  ['logMed', 4, 1, -190, 85, 1, 3, 2],
  ['logShort', 3, -1, 550, 75, 1, 4, 3],
  ['turtle', 2, 1, -80, 100, 0, 2, 4],
  ['truck', 1, -1, 550, 120, 0, 3, 5],
  ['carBlue', 2, 1, -100, 100, 10, 5, 6], 
  ['carYellow', 3, 1, -130, 90, 0, 8, 7],
  ['fireCar', 4, 1, -130, 105, 2, 5, 8],
  ['carGreen', 5, 1, -130, 85, 15, 10, 9],
];*/

var Level = function(levelData,callback) {
  this.levelData = [];
  for(var i = 0; i < levelData.length; i++) {
    this.levelData.push(Object.create(levelData[i]));
  }
  this.t = 0;
  this.callback = callback;
}

Level.prototype.draw = function(ctx) { }

Level.prototype.step = function(dt) {
  var idx = 0, remove = [], curObj = null;
  this.t += dt * 10;


  for(var i = 0; i < this.levelData.length; i++){
    curObj = this.levelData[i];
    if(curObj[0].substring(0, 3) == 'log' || curObj[0] == 'turtle'){
      if(curObj[5] == 0){   
        curObj[5] += dt;
         this.board.add(Object.create(new Trunk(curObj[0], curObj[1], curObj[2], curObj[3], curObj[4])));
       }
       else if(curObj[5] >= curObj[6]){
         curObj[5] = 0;
       }
       else{
         curObj[5] += dt;
       }
    }
   else{
    if(curObj[5] == 0){   
      curObj[5] += dt;
       this.board.add(Object.create(new Car(curObj[0], curObj[1], curObj[2], curObj[3], curObj[4])));
     }
     else if(curObj[5] >= curObj[6]){
       curObj[5] = 0;
     }
     else{
       curObj[5] += dt;
     }
   }

    this.levelData[i] = curObj;
  
  }
  this.levelData.sort(function(a, b){
    return a[7] - b[7];
  });
}
