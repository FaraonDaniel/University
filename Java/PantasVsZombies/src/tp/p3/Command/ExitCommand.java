package tp.p3.Command;

import tp.p3.ControllerAndManager.Game;
import tp.p3.Excepciones.CommandParseException;

public class ExitCommand extends NoParamsCommand{

	public ExitCommand(String commandText, String commandInfo, String helpInfo) {
		super(commandText, commandInfo, helpInfo);
	}
	
	public ExitCommand() {
		super("[E]xit","<exit>","terminate the program.");
	}
	
	public String helpText(){
		return " " + commandText + ": " + this.helpText;
	}

	@Override
	public boolean execute(Game game) {
		game.setFinalizado(true);
		System.out.println("Game Over");
		return false;
	}

	@Override
	public Command parse(String[] commandWords) throws CommandParseException {
		String option = commandWords[0].toUpperCase();
		if(option.equals("EXIT") || option.equals("E")){
			if(commandWords.length == 1){
				return this;
			}
			else{
				throw new CommandParseException("El numero de argumentos es incorrecto,\n recuerde: <exit>");
			}
		}
		else{
			return null;
		}
	}




}
