package tp.p3.ControllerAndManager;

import java.io.IOException;
import java.util.Scanner;
import tp.p3.Command.Command;
import tp.p3.Command.CommandParser;
import tp.p3.Excepciones.CommandExecuteException;
import tp.p3.Excepciones.CommandParseException;
import tp.p3.Excepciones.FileContentsException;

public class Controller {
	
	private Game game;
	private Scanner scanner;
	private boolean printearTablero=true;
	
	
	public Controller(String[] args, Game game) {
		this.game = game;
		this.scanner = new Scanner(System.in);
	}
	
	//Ejecuta el juego, y el comando que se le introduce. Si no es correcto se imprime un error.
	public void run(){
		while (!game.isFinalizado()) {
			if(this.printearTablero){
				game.printGame();
			}
			this.printearTablero=true;
			try{
				Command command = userCommand();
				if (command != null) {
					printearTablero = command.execute(game);
				}
				else{
					this.printearTablero = false;
					throw new CommandParseException ("Comando desconocido.");
				}
			}
			catch(NumberFormatException e){
				System.out.println(e);
				setNoPrintGameState();
			}
			catch(CommandParseException e){
				System.out.println(e);
				setNoPrintGameState();
			}
			catch(CommandExecuteException e){
				System.out.println(e);
				setNoPrintGameState();
			}
			catch(FileContentsException e) {
				System.out.println(e);
				setNoPrintGameState();
			}
			catch(IOException e){
				System.out.println(e);
				setNoPrintGameState();
			}
		}
	}
	public void setNoPrintGameState() {
		this.printearTablero=false;
		
	}

	public Game getGame() {
		return game;
	}
	
	public Command userCommand() throws NumberFormatException, CommandParseException{
		System.out.println();
		System.out.print("Command :>");
		String commandoActual = scanner.nextLine().toUpperCase().trim();
		String[] words = commandoActual.split("\\s+");
		return CommandParser.parseCommand(words);
	}
	
	public void setGame(Game game) {
		this.game = game;
	}

}
