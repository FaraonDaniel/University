package tp.p3.ControllerAndManager;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.util.Random;



import tp.p3.Excepciones.CommandExecuteException;
import tp.p3.Excepciones.FileContentsException;
import tp.p3.Objects.ListPlants;
import tp.p3.Objects.ListZombies;
import tp.p3.Objects.Plant;
import tp.p3.Objects.Sun;
import tp.p3.Objects.Zombie;
import tp.p3.Printer.GamePrinter;
import tp.p3.Printer.ReleasePrinter;

public class Game {
	private int ciclos;
	private Random rand;
	public static final int FILAS = 4;
	public static final int COLUMNAS = 8;
	private boolean finalizado;
	private GamePrinter gamePrinter;
	private long seed;
	private SunManager smanager;
	private ListZombies listZ;
	private ListPlants listP;
	private ZombieManager zmManager;
	private Level lvl;
	private boolean noPrint;
//-----------------------------------------------------------------
	
	//Constructor
	public Game(Level lvl, long semilla) {
		this.ciclos = 0;
		this.rand = new Random(semilla);
		this.finalizado = false;
		this.listP = new ListPlants();
		this.listZ = new ListZombies();
		this.seed=semilla;
		this.noPrint=true;
		this.smanager= new SunManager(this);
		this.gamePrinter = new ReleasePrinter(FILAS, COLUMNAS, this, this.smanager);
		this.lvl = lvl;
		switch (lvl) {
		case EASY:
			this.zmManager = new ZombieManager(3, this.rand);
			
			break;
		case HARD:
			this.zmManager = new ZombieManager(5, this.rand);
			
			break;
		
		case INSANE: 
			this.zmManager = new ZombieManager(10, this.rand);
			
			break;
		}
	}

	//---------------------------------------------- 
	
	public Level getLvl() {
		return lvl;
	}
	
	public void setGamePrinter(GamePrinter gamePrinter) {
		this.gamePrinter = gamePrinter;
	}
	
	//Funcion que devuelve true si los numeros introducidos estan en el rango del tablero de las plantas.
	public boolean plantaEstaDentroTablero(int x, int y){
		if(x<0||x>=FILAS || y<0 || y>=COLUMNAS-1){
			return false;
		}
		return true;
	}
	
	//Funcion que devuelve true si los numeros introducidos estan en el rango del tablero.
	public boolean estaDentroTableroSoles(int x, int y){
		if(x<0||x>=FILAS || y<0 || y>=COLUMNAS){
			return false;
		}
		return true;
	}
	
	
	//Funcion donde se actualiza el teclado y las acciones de las planta y zombies.
	public void update() {
		this.ciclos++;		
		actualizarSolesPlantas();
		if(this.ciclos % 5 == 0) {
			añadirSol();
		}
		ataquePlantas();
		moverZombies();
		ataqueZombie();		
		this.listP.eliminarMuertos();
		this.listZ.eliminarMuertos();
		gananPlantas();
		gananZombies();
	}
	
	public void setNoPrint(boolean noPrint){
		this.noPrint=noPrint;
	}
	
	public boolean getNoPrint(){
		return this.noPrint;
	}
	
	
	//Se recorre el tablero realizando los ataques de los lanzaguisantes a los zombies.
	private void ataquePlantas(){
		for(int i = 0; i < this.listP.getContadorPlantas(); i++){
			if(!this.listP.getListPlants()[i].getNombre().equals("S")){
				//Ataque petacereza.
				if(this.listP.getListPlants()[i].getNombre().equals("C")){
					ataquePetacereza(i);
				}
				//Ataque peashooter.
				if(this.listP.getListPlants()[i].getNombre().equals("P")){
					ataquePeashooter(i);
				}
			}
		}
	}
	
	//Ataque Petacereza
	private void ataquePetacereza(int i){
		if(this.listP.realizaAccion(i)){
			
			for(int j = 0; j < this.listZ.getContadorZombies(); j++){
				if(this.listP.getListPlants()[i].estaEnRadio(this.listZ.getListZombies()[j].getX(), this.listZ.getListZombies()[j].getY())){
					this.listZ.recibeGolpes(j, 10);
				}
			}
			this.listP.recibeGolpe(i, 10);
		}
	}
	
	//Ataque Peashooter
	private void ataquePeashooter(int i){
		boolean encontrado = false;
		int contador = 0;
		
		while(contador < this.listZ.getContadorZombies() && !encontrado) {
			if(this.listP.getListPlants()[i].estaEnRadio(this.listZ.getListZombies()[contador].getX(), this.listZ.getListZombies()[contador].getY())){
				this.listZ.recibeGolpes(contador, this.listP.getListPlants()[i].getDannio());
				encontrado = true;
			}
			contador++;
		}
	}
	
	//Se recorre el tablero comprobando si los zombies atacan a las plantas.
	private void ataqueZombie(){
		for(int i = 0; i < this.listZ.getContadorZombies(); i++){
			for(int j = 0; j < this.listP.getContadorPlantas(); j++){
				if(this.listZ.getListZombies()[i].getX() == this.listP.getListPlants()[j].getX() && 
						this.listZ.getListZombies()[i].getY()-1 == this.listP.getListPlants()[j].getY()){
					this.listP.recibeGolpe(j, 1);
				}
			}
		}
	}
	
	//Accion de mover zombies del tablero
	public void moverZombies(){
		for(int i = 0; i < this.listZ.getContadorZombies(); i++){
			if((listZ.getListZombies()[i].update()) && (!existeAlguien(this.listZ.getListZombies()[i].getX(), this.listZ.getListZombies()[i].getY()-1, this.listP, this.listZ))) {
				this.listZ.moverZombie(i);
			}
		}
	}
	
	public int getCiclos() {
		return ciclos;
	}
	
	public int getRestantes() {
		return this.zmManager.getRestantes();
	}

	//Funcion que maneja la creacion de los zombies dentro del tablero.
	public void computerAction(){
		int casilla;
		double fre = 0;
		switch(lvl) {
		case EASY: fre=0.1;break;
		case HARD:fre=0.2;break;
		case INSANE: fre=0.3;break;
		}
		casilla = rand.nextInt(FILAS);
		if(!existeAlguien(casilla, COLUMNAS-1, this.listP, this.listZ)){
			if(zmManager.isZombieAdded(fre,seed)){
				zmManager.setRestantes();
				listZ.añadirZombie(ZombiesFactory.getZombie(randomZombie()), casilla, COLUMNAS-1);
			}
		}	
	}
	
	
	private String randomZombie() {
		switch (this.rand.nextInt(3)) {
		case 0:
			return "Z";
		case 1:
			return "X";
		case 2: 
			return "W";
		}
		return null;
	}
	
	//Funcion que anniade la planta con las coordenadas al tablero.
	public void añadir(Plant plant, int x, int y) throws CommandExecuteException{
		if(existeAlguien(x, y, this.listP, this.listZ)) {
			throw new CommandExecuteException("Ha ocurrido un fallo al plantar " + plant.getNombre() +
					"en la casilla " + x + " " + y + ". Casilla ya ocupada.");
		}
		else {
		this.listP.añadirPlanta(plant, x, y);
		this.smanager.cobrarPlanta(plant.getCoste());
		}
	}
	
	public int getLimiteFilas() {
		return FILAS;
	}

	public int getLimiteColumnas() {
		return COLUMNAS;
	}
	
	public boolean isFinalizado() {
		return finalizado;
	}
	
	//Funcion que devuelve true si las plantas han ganado y no queda ningun zombie por sacar al campo.
	public void gananPlantas() {
		if (!zmManager.quedanZombies() && listZ.getContadorZombies() == 0) {
			this.finalizado = true;
			this.gamePrinter.encodeGame(this);
			System.out.println("Game Over");
			System.out.println("Player Wins!");
		}
	}
	
	//Funcion que devuelve true si algun zombie ha llegado a la cualquier columna 0 del tablero.
	public void gananZombies() {
		if(listZ.ZombieGanador()) {
			this.finalizado = true;
			this.gamePrinter.encodeGame(this);
			System.out.println("Game Over");
			System.out.println("Zombies win!");
		}
	}

	public void setFinalizado(boolean b) {
		this.finalizado = b;
		
	}
	
	//Saca los soles de las plantas que le toque echar soles
	public void actualizarSolesPlantas() {
		Sun nextSun = null;
		for(int i = 0; i < this.listP.getContadorPlantas(); i++) {
			if(this.listP.esGirasol(i) && smanager.isPositionEmpty(this.listP.getListPlants()[i].getX(), this.listP.getListPlants()[i].getY())) {
				
				nextSun = new Sun(this, 5, "Sol suelto por el mapa");
				nextSun.establecerPos(this.listP.getListPlants()[i].getX(), this.listP.getListPlants()[i].getY());
				smanager.addSun(nextSun, nextSun.getX(), nextSun.getY());
			}
		}
	}

	public long getSeed() {
		return this.seed;
	}
	
	public SunManager getScmanager() {
		return smanager;
	}
	
	public GamePrinter getGamePrinter() {
		return this.gamePrinter;
	}

	public int getZombiesRestantes(){
		return zmManager.getRestantes();
	}
	
	//Añade sol
	public void añadirSol() {
		int x, y;
		boolean añadido = false;
		Sun solActual = new Sun(this, 5, "Sol suelto por el mapa");
		while(!añadido) {
		x = rand.nextInt(4);
		y = rand.nextInt(8);
			if(smanager.isPositionEmpty(x, y)) {
				solActual.establecerPos(x, y);
				smanager.addSun(solActual, x, y);
				añadido = true;
			}
		}
	}
	public void recogerSol(int x, int y) {
		smanager.recogerSol(x, y);
	}
	//Nos indica si en esa posicion hay un objeto o esta vacio
	public boolean hayAlguien(int x, int y){
		boolean ok1=false;
		boolean ok2=false;
		ok1 = listP.exitePlanta(x, y);
		ok2 = listZ.exiteZombie(x, y);
		return ok1||ok2;
	}
	public boolean existeAlguien(int x, int y, ListPlants planta, ListZombies zombies ){
		return planta.exitePlanta(x, y) || zombies.exiteZombie(x, y);
	}
	
	public void printGame() {
		gamePrinter.imprimirDatos();
		if(!getNoPrint()) {
			this.gamePrinter.encodeGame(this);
			}
		else{
			this.gamePrinter.encodeGame(this);
		}
	}

	public ListZombies getListZ() {
		return listZ;
	}

	public ListPlants getListP() {
		return listP;
	}
	
	public boolean esPlanta(int x, int y, int indice) {
		return this.listP.esPlanta(x, y, indice);
	}
	
	public boolean esZombie(int x, int y, int indice) {
		return this.listZ.esZombie(x, y, indice);
	}
	
	
	public void store(BufferedWriter buff) throws IOException{
		buff.write("Plants Vs Zombies v3.0\n");
		buff.write("Cicles: " + this.ciclos + "\n");
		buff.write("Suncoins: " + this.smanager.getSolesDePartida() + "\n");
		buff.write("Level: " + this.lvl + "\n");
		buff.write("remZombies: " + this.zmManager.getRestantes() + "\n");
		buff.write("ListPlants: ");
		this.listP.store(buff);
		buff.write("ListZombies: ");
		this.listZ.store(buff);
	}
	
	
	public String[] leerPalabraBuffer(BufferedReader buff) throws IOException {
		 String[] palabra = buff.readLine().split(" ");
		 return palabra;
	}
	
	public void load(BufferedReader buff) throws NumberFormatException, IOException, CommandExecuteException, FileContentsException{
		Game juego = new Game(this.lvl, this.seed);
		int ciclos, suncoins, numZombies;
		Level lvl;
		try{
			juego.copiarJuego(this);
			this.reset();
			buff.readLine();
	        ciclos = Integer.parseInt(leerPalabraBuffer(buff)[1]);
	        suncoins = Integer.parseInt(leerPalabraBuffer(buff)[1]);
	        
	        if((lvl = eligeNivel(leerPalabraBuffer(buff)[1]))==null){
	        	throw new CommandExecuteException("El Nivel cargado es incorrecto");
	        }
	        numZombies = Integer.parseInt(leerPalabraBuffer(buff)[1]);
	        ListPlants plantas = new ListPlants();
	        ListZombies zombies = new ListZombies();
	        gestionarListaPlantas(leerPalabraBuffer(buff), plantas, zombies);
	        gestionarListaZombies(leerPalabraBuffer(buff), zombies, plantas);
	        
	        
	        if(numZombiesCorrecto(zombies.getContadorZombies() + numZombies, lvl)) {
	        	rellenarJuego(ciclos, suncoins, lvl, numZombies, plantas, zombies);
	        }
	        else {
	        	this.copiarJuego(juego);
	        	throw new CommandExecuteException("Numero de zombies incorrecto");
	        }
	        
		}
		catch(NumberFormatException e){
			this.copiarJuego(juego);
			throw e;
		}
		catch(CommandExecuteException e) {
			this.copiarJuego(juego);
			throw e;
		}
		catch(FileContentsException e){
			this.copiarJuego(juego);
			throw e;
		}
		catch(IOException e){
			this.copiarJuego(juego);
			throw e;
		}
    }
	
	public void rellenarJuego(int ciclos, int suncoins, Level lvl, 
			int numZombies, ListPlants listp, ListZombies listz) {
		
		this.ciclos = ciclos;
        this.smanager.setSolesPartida(suncoins);
        this.lvl = lvl;
        this.zmManager.setZombiesPartida(numZombies);
        this.listP = listp;
        this.listZ = listz;
	}
	
	private void gestionarListaPlantas(String[] palabra, ListPlants plantas, ListZombies zombies) 
			throws FileContentsException, NumberFormatException{
		
		try{
		 for (int i = 1; i < palabra.length; i++) {
	        	String[] valor = palabra[i].split(":");
	        	Plant planta =PlantsFactory.getPlant(valor[0]);
	        	if(planta!=null){
	        		if(Integer.parseInt(valor[1]) <= 0 || planta.getResistencia() < Integer.parseInt(valor[1])){
	        			throw new FileContentsException("Vida no correcta de la planta " + planta.getNombre());
	        		}
	        		else{
	        			planta.setResistenciaInicial(Integer.parseInt(valor[1]));
		        		if(!plantaEstaDentroTablero(Integer.parseInt(valor[2]),Integer.parseInt(valor[3]))){
		        			throw new FileContentsException("Parametros de la planta "+ planta.getNombre() + " incorrectos.");
		        		}
		        		else {
		        			if(!existeAlguien(Integer.parseInt(valor[2]),Integer.parseInt(valor[3]), plantas, zombies)) {
				        		planta.setX(Integer.parseInt(valor[2]));
					        	planta.setY(Integer.parseInt(valor[3]));
		        			}
		        			else{
		        				throw new FileContentsException("Se ha intentado cargar dos objetos en la posicion " + Integer.parseInt(valor[2]) + " " + Integer.parseInt(valor[3]));
		        			}
		        		}
		        		if(plantas.getContadorPlantas()>=FILAS*(COLUMNAS-1)){
		                    throw new FileContentsException("Se han cargado más plantas de las posibles");
		                }
		        		planta.setCiclos(Character.getNumericValue(valor[4].charAt(0)));
		        	}
	        	}
	        	plantas.añadirPlanta(planta);
			}
		}
		catch(NumberFormatException e){
			throw e;
		}
		catch(FileContentsException e){
			throw e;
		}
	}
	
	
	
	private void gestionarListaZombies(String[] palabra, ListZombies zombies, ListPlants plantas) throws NumberFormatException, CommandExecuteException, FileContentsException {
		
		try {
		 for (int i = 1; i < palabra.length; i++) {
	        	String[] valor = palabra[i].split(":");
	        	Zombie zomb = ZombiesFactory.getZombie(valor[0]);
	        	if(zomb!=null && numZombiesCorrecto(palabra.length-1, lvl)){
	        		if(Integer.parseInt(valor[1]) <= 0 || zomb.getResistencia() < Integer.parseInt(valor[1])){
	        			throw new CommandExecuteException("Vida no correcta del zombie " + zomb.getNombre());
	        		}
	        		else{
	        			zomb.setResistencia(Integer.parseInt(valor[1]));
		        		if(Integer.parseInt(valor[2]) >= 4 || Integer.parseInt(valor[3]) >= 8){
		        			throw new CommandExecuteException("Parametros del zombie incorrectos.");
		        		}
		        		else {
		        			if(!existeAlguien(Integer.parseInt(valor[2]),Integer.parseInt(valor[3]), plantas, zombies)) {
			        			zomb.setX(Integer.parseInt(valor[2]));
				        		zomb.setY(Integer.parseInt(valor[3]));
				        		zomb.setCiclos(Character.getNumericValue(valor[4].charAt(0)));
				        		zombies.añadirZombie(zomb);
		        			}
		        			else{
		        				throw new FileContentsException("Ya existe un objeto en la posicion " + Integer.parseInt(valor[2]) + " " + Integer.parseInt(valor[3]));
		        			}
		        		}
		        		
	        		}
	        	}
	        	
			}
		}
		catch(NumberFormatException e){
			throw e;
		}
		catch(CommandExecuteException e){
			throw e;
		}
	}
	
	
	private static Level eligeNivel(String arg){
		Level lvl;
		switch(arg){ 
		
		case "EASY": {
			lvl = Level.EASY;
			break;
			}
		case "HARD":{
			lvl= Level.HARD;
			break;
			}
		case "INSANE": {
			lvl= Level.INSANE;
			break;
			}
		default:
			return null;
		}
		
		return lvl;
	}
	
	private boolean numZombiesCorrecto(int zombie, Level lvl){
		boolean ok=false;
		switch(lvl){ 
			case EASY:{
				ok = (zombie <= 3);
				break;
			}
			case HARD: {
				ok = (zombie <= 5);
				break;
			}
			case INSANE:{
				ok = (zombie <= 10);
				break;
			}
		}
		return ok;
	}

	public void copiarJuego(Game game) {
		this.ciclos = game.getCiclos();
		this.rand = game.getRandom();
		this.finalizado = game.isFinalizado();
		this.listP = game.getListP();
		this.listZ = game.getListZ();
		this.seed=game.getSeed();
		this.noPrint=game.getNoPrint();
		this.smanager= game.getScmanager();
		this.gamePrinter = game.getGamePrinter();
		this.lvl = game.getLvl();
		this.zmManager = game.getZmManager();
	}
	
	public Random getRandom() {
		return this.rand;
	}
	
	
	
	public ZombieManager getZmManager() {
		return this.zmManager;
	}

	public void reset() {
		this.ciclos = 0;
		this.rand = new Random(this.seed);
		this.finalizado = false;
		this.listP = new ListPlants();
		this.listZ = new ListZombies();
		this.noPrint=true;
		this.smanager= new SunManager(this);
		this.gamePrinter = new ReleasePrinter(FILAS, COLUMNAS, this, this.smanager);
		switch (this.lvl) {
		case EASY:
			this.zmManager = new ZombieManager(3, this.rand);
			break;
		case HARD:
			this.zmManager = new ZombieManager(5, this.rand);
			break;
		case INSANE: 
			this.zmManager = new ZombieManager(10, this.rand);
			break;
		}
	}
}
