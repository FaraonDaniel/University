package tp.p3.Command;


import tp.p3.ControllerAndManager.Game;
import tp.p3.Excepciones.CommandParseException;

public class HelpCommand extends NoParamsCommand {

	public HelpCommand(String commandText, String commandInfo, String helpInfo) {
		super(commandText, commandInfo, helpInfo);
	}
	
	public HelpCommand() {
		super("[H]elp","<Help>","print this help message.");
	}
	
	public String helpText(){
		return " " + commandText + ": " + this.helpText;
	}
	
	@Override
	public boolean execute(Game game) {
		System.out.println("The available commands are:");
		System.out.print(CommandParser.commandHelp());
		return false;
	}

	@Override
	public Command parse(String[] commandWords) throws CommandParseException {
		String option = commandWords[0].toUpperCase();
		if(option.equals("H") || option.equals("HELP")){
			if(commandWords.length == 1){
				return this;
			}
			else{
				throw new CommandParseException("Numero de argumentos incorrecto,\n recuerde <Help>");
			}
		}
		else {return null;}
	}

}
