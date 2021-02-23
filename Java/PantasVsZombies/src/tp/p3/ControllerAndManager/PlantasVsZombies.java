package tp.p3.ControllerAndManager;


import java.util.Scanner;
import tp.p3.ControllerAndManager.Controller;
import tp.p3.ControllerAndManager.Game;
import tp.p3.Excepciones.ExceptionArgs;


public class PlantasVsZombies {
	static public void main(String []args){
		Level lvl = null;
		boolean argumentosUsuario=false;
		long seed = 0;
		boolean ok=false;
		while(!ok){
			try{
				if(argumentosUsuario){
					Scanner capt = new Scanner(System.in);
					args = argsUsuario(capt);
					//capt.close();
				}
				argumentosUsuario = true;
				if(args.length == 2){
					lvl = eligeNivel(args[0].toUpperCase());
					seed = Integer.parseInt(args[1]);
					ok=true;
				}
				else{
					throw new ExceptionArgs("Se ha introducido un numero de argumentos invalidos");
				}
			}
			catch(ExceptionArgs e){
				System.out.println(e);
			}
			catch(RuntimeException e){
				System.out.println("Usage: plantsVsZombies <EASY|HARD|INSANE> [seed]: the seed must be a number");
			}
		}
		Game game = new Game(lvl, seed);
		Controller controlador = new Controller(args, game);
		controlador.run();
	
	}
	private static String[] argsUsuario(Scanner capt){
		System.out.print("Introduce de nuevo los argumentos <level> <seed> :");
		String commandoActual = capt.nextLine().toUpperCase().trim();
		String[] words = commandoActual.split("\\s+");
		return words;
	}
		
	private static Level eligeNivel(String arg) throws ExceptionArgs{
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
			throw new ExceptionArgs("Usage: plantsVsZombies <EASY|HARD|INSANE> [seed]: level must be one of: EASY, HARD, INSANE");
		}
		
		return lvl;
	}

}