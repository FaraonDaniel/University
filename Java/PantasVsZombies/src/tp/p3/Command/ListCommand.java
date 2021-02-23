package tp.p3.Command;

import tp.p3.ControllerAndManager.Game;
import tp.p3.ControllerAndManager.PlantsFactory;
import tp.p3.Excepciones.CommandParseException;

public class ListCommand extends NoParamsCommand {
	
	public ListCommand(String commandText, String commandInfo, String helpInfo) {
		super(commandText, commandInfo, helpInfo);
	}
	
	public ListCommand() {
		super("[L]ist","<List>","print the list of available plants.");
	}
	
	public String helpText(){
		return " " + commandText + ": " + this.helpText;
	}

	@Override
	public boolean execute(Game game) {
		System.out.print(PlantsFactory.listOfAvilablePlants());
		return false;
	}

	@Override
	public Command parse(String[] commandWords) throws CommandParseException {
		String option = commandWords[0].toUpperCase();
		if(option.equals("L") || option.equals("LIST")){
			if(commandWords.length == 1){
				return this;
			}
			else{
				throw new CommandParseException("Numero de argumentos incorrecto,\n recuerde: <List>");
			}
		}
		else{
			return null;
		}
	}

}
