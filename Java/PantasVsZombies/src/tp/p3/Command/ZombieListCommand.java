package tp.p3.Command;

import tp.p3.ControllerAndManager.Game;
import tp.p3.ControllerAndManager.ZombiesFactory;
import tp.p3.Excepciones.CommandParseException;

public class ZombieListCommand extends Command {

	public ZombieListCommand(String commandText, String commandInfo, String helpInfo) {
		super(commandText, commandInfo, helpInfo);
	}
	
	public ZombieListCommand() {
		super("[Z]ombieList","<zombieList>","print the list of zombies.");
	}
	
	public String helpText(){
		return " " + commandText + ": " + this.helpText;
	}

	@Override
	public boolean execute(Game game) {
		System.out.println(ZombiesFactory.listOfAvilableZombies());
		return false;
	}

	@Override
	public Command parse(String[] commandWords) throws CommandParseException {
		String option = commandWords[0].toUpperCase();
		if(option.equals("ZOMBIELIST") || option.equals("Z")){
			if(commandWords.length == 1){
				return this;
			}
			else{
				throw new CommandParseException("Numero de argumentos incorrecto,\n recuerde: <zombieList>");
			}
		}
		else {return null;}
	}

}
