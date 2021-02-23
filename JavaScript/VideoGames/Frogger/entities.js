var sprites = {
escenario:{sx:421,sy:0,w:550,h:625,frame:1},
froggerLogo:{sx:0,sy:392,w:272,h:167,frame:1},
frog: { sx: 0, sy: 342, w: 38, h: 40, frame: 1 },
missile: { sx: 0, sy: 42, w: 7, h: 20, frame: 1 },
carBlue: { sx: 8, sy: 7, w: 90, h: 46, frame: 1 },
carYellow: { sx: 213, sy: 5, w: 94, h: 48, frame: 1 },
carGreen: { sx: 109, sy:6, w: 94, h: 48, frame: 1 }, 
truck: { sx: 148, sy: 61, w: 200, h: 48, frame: 1 },
fireCar: { sx: 7, sy: 61, w: 124, h: 46, frame: 1 },
logMed: { sx: 10, sy: 121, w: 191, h: 46, frame: 1 },
logShort: { sx: 271, sy: 170, w: 129, h: 46, frame: 1 },
logLong: { sx: 10, sy: 169, w: 248, h: 46, frames: 1 },
turtle: { sx: 336, sy: 341, w: 49, h:  48, frame: 1 },
water:{sx:421, sy:49, w:587, h:240 , frame: 1},
grass: {sx: 422, sy: 0, w: 550, h: 46, frame: 1},
skull: {sx: 212, sy: 128, w: 47, h: 35, frames: 4}
};

var level1 = [
  // Start,    End, Gap,  Type,   Override
 //tipo, carril, sentido, inicio, velocidad,tiempoAux, tiempoEspera
   ['logShort', 5, -1, 550, 90, 0, 3], 
   ['logLong', 1, -1, 550, 60, 2, 5],
   ['logMed', 4, 1, -190, 40, 0, 8],
   ['logShort', 3, -1, 550, 75, 0, 6],
   ['turtle', 2, 1, -80, 100, 0, 2],
   ['truck', 1, -1, 550, 120, 0, 3],
   ['carBlue', 2, 1, -100, 100, 10, 5], 
   ['carYellow', 3, 1, -130, 90, 0, 8],
   ['fireCar', 4, 1, -130, 105, 2, 5],
   ['carGreen', 5, 1, -130, 85, 15, 10],
 ];

var OBJECT_PLAYER = 1,
    OBJECT_SURFACE = 2,
    OBJECT_ENEMY = 4,
    OBJECT_WATER = 8,
    OBJECT_GRASS = 16,
    OBJECT_SCENARIO = 32; 
    OBJECT_SPAWN = 64;


/// CLASE PADRE SPRITE
var Sprite = function()  
 { }

Sprite.prototype.setup = function(sprite,props) {
  this.sprite = sprite;
  this.merge(props);
  this.frame = this.frame || 0;
  this.w =  SpriteSheet.map[sprite].w;
  this.h =  SpriteSheet.map[sprite].h;
}

Sprite.prototype.merge = function(props) {
  if(props) {
    for (var prop in props) {
      this[prop] = props[prop];
    }
  }
}
Sprite.prototype.draw = function(ctx) {
  SpriteSheet.draw(ctx,this.sprite,this.x,this.y,this.frame);
}

Sprite.prototype.hit = function(damage) {
  this.board.remove(this);
}



// PLAYER

var PlayerFrog = function() { 

  this.setup('frog', { vx: 0, frame: 0, reloadTime: 0.095});
  this.vx=0;
   this.x = Math.floor((Game.width/(40))/2 + 240);
   this.y = Game.height - this.h;

   this.reload = this.reloadTime;


   this.step = function(dt) {
    //if(this.reload > 0) {
    //  this.reload -= dt;
    //  return}


     if(Game.keys['left']) { this.x -= 40 - this.vx*dt; }
     else if(Game.keys['right']) { this.x += 40 + this.vx*dt; }
     else if(Game.keys['up']){this.y -= 48 }
     else if(Game.keys['down']){this.y += 48}

    this.x += this.vx * dt;

     if(this.x < 0) { this.x = 0; }
     else if(this.x > Game.width - this.w) { 
       this.x = Game.width - this.w 
      }
      else if(this.y < 0) { this.y = 0;}
       else if(this.y > Game.height - this.h) { 
      this.y = Game.height - this.h;
        }
    Game.keys = {};
    
    this.vx=0;
    var collisionWater = this.board.collide(this,OBJECT_WATER);
    var collisionTrunk = this.board.collide(this,OBJECT_SURFACE);
    
    if(collisionWater && !collisionTrunk) {
      //collision.hit(this.damage);
      this.board.remove(this);
      this.board.add(new Death(this.x, this.y));
      loseGame();
    }
  }
    this.onTrunk = function(vt){
      this.vx=vt;
    }
  
 }



PlayerFrog.prototype = new Sprite();
PlayerFrog.prototype.type = OBJECT_PLAYER;
PlayerFrog.prototype.zIndex=1;
//PlayerFrog.prototype.index = 100;

PlayerFrog.prototype.hit = function(damage) {
  //if(this.board.remove(this)) {
    //loseGame();
  //}
}
/*PlayerFrog.prototype.onTrunk = function(vt){
  this.vx=vt;
}
*/

var Car = function(tipo, carril, dir, startPos, vel) { 

  this.y =  289 + 48 * carril;
  this.x = startPos;
  
  this.setup(tipo, { vx: vel, frame: 0, reloadTime: 0.10, maxVel: 0 });
    this.step = function(dt) {
      this.x += this.vx * dt * dir;
      if(this.x < 0 - Game.width) {
          this.board.remove(this);
     }
     var collisionCar = this.board.collide(this,OBJECT_PLAYER);
     if(collisionCar) {
       //collision.hit(this.damage);
       this.board.remove(collisionCar);
       this.board.add(new Death(collisionCar.x, collisionCar.y));
       loseGame();
     }
    }
     // this.reload = this.reloadTime;
  }

  Car.prototype = new Sprite();
  Car.prototype.type = OBJECT_ENEMY;
  Car.prototype.zIndex=4;

  Car.prototype.hit = function(damage) {
    /*if(this.board.remove(this)) {
      loseGame();
    }*/
  }

  //GRASS

var Grass = function() {
  this.x=0;
  this.y=0;
  this.setup("grass", { vx: 0, frame: 0});
  this.step = function(dt){

    var collisionWin = this.board.collide(this, OBJECT_PLAYER);
     if(collisionWin){
      this.board.remove(collisionWin);
       winGame();
     }

  }
  this.draw = function(){};
}
Grass.prototype = new Sprite();
Grass.prototype.type = OBJECT_GRASS;
Grass.prototype.zIndex=5;


//DEATH
var Death = function(centerX,centerY) {
  this.setup("skull", { frame: 0 });
  this.x = centerX;
  this.y = centerY;
  this.subFrame = 0;
};

Death.prototype = new Sprite();
Death.prototype.zIndex=2;

Death.prototype.step = function(dt) {
  this.frame = Math.floor(this.subFrame++/16);
  if(this.subFrame >= 16*4) {
    this.board.remove(this);
  }
};

//WATER

var Water = function() {
  this.x=0;
  this.y=49;
  this.setup("water", { vx: 40, frame: 0, reloadTime: 0.10, maxVel: 0 });
  this.step = function(dt){
  }
  this.draw = function(){};
}
Water.prototype = new Sprite();
Water.prototype.type = OBJECT_WATER;
Water.prototype.zIndex=6;



//TRUNKS

var Trunk =  function(tipo, carril, dir, startPos, vel) { 

  //Calculamos el carril para sacar al tronco:
  this.y =  49 * carril;
  this.x = startPos;
  this.setup(tipo, { vx: vel, frame: 0, reloadTime: 0.10, maxVel: 0 });
    this.step = function(dt) {
      this.x += this.vx * dt*dir;
      if(this.x < 0 - Game.width) {
          this.board.remove(this);
     }
     collision = this.board.collide(this, OBJECT_PLAYER);
     if(collision){
     collision.onTrunk(this.vx*dir);
     //PlayerFrog.onTrunk(this.vx);
     }
    }
     // this.reload = this.reloadTime;
  }

  Trunk.prototype = new Sprite();
  Trunk.prototype.type = OBJECT_SURFACE;
  Trunk.prototype.zIndex=3;
  Trunk.prototype.hit = function(damage) {
    /*if(this.board.remove(this)) {
      loseGame();
    }*/
  }


//SPAWNER

var Spawn = function(callback){

  this.levelData = [];
  for(var i = 0; i < level1.length; i++) {
    this.levelData.push(Object.create(level1[i]));
  }
  this.t = 0;
  this.callback = callback;

  this.step = function(dt){
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


  }
  this.draw = function(){}
}

Spawn.prototype = new Sprite();
Spawn.prototype.zIndex=7;
Spawn.prototype.type = OBJECT_SPAWN;




//ESCENARIO

var Escenario = function(){
  this.setup('escenario', { frame: 0 });
  this.x = 0;
  this.y = 0;
  this.step = function(dt){

  }
}
Escenario.prototype = new Sprite();
Escenario.prototype.type = OBJECT_SCENARIO;

//TITTLEFROG
var froggerLogo = function(){
  this.setup('froggerLogo', { frame: 0 });
  this.x = 150;
  this.y = 150;
  this.step = function(dt){

  }
}
froggerLogo.prototype = new Sprite();
froggerLogo.prototype.type = OBJECT_SCENARIO;
froggerLogo.prototype.zIndex=8;



