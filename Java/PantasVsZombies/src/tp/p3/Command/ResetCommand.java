package tp.p3.Command;

import tp.p3.ControllerAndManager.Game;
import tp.p3.Excepciones.CommandParseException;


public class ResetCommand extends NoParamsCommand{

	public ResetCommand(String commandText, String commandInfo, String helpInfo) {
		super(commandText, commandInfo, helpInfo);
	}
	
	public ResetCommand() {
		super("[R]eset","<Reset>","resets game");
	}
	
	public String helpText(){
		return " " + commandText + ": " + this.helpText;
	}
	
	@Override
	public boolean execute(Game game) {
		game.reset();
		return true;
	}

	@Override
	public Command parse(String[] commandWords) throws CommandParseException {
		String part = commandWords[0].toUpperCase();
		if((part.equals("R"))||part.equals("RESET")){
			if(commandWords.length==1)
				return this;
			else
				throw new CommandParseException("Numero de argumetos incorrecto.\n recuerde: <Reset>");
		}
		else
			return null;
	}

}
