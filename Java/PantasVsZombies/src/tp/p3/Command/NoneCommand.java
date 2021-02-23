package tp.p3.Command;


import tp.p3.ControllerAndManager.Game;
import tp.p3.Excepciones.CommandParseException;
	
public class NoneCommand extends NoParamsCommand{
	private UpdateCommand update;
	public NoneCommand(String commandText, String commandInfo, String helpInfo) {
		super(commandText, commandInfo, helpInfo);
	}
	
	public NoneCommand() {
		super("[N]one","<none>","skips cycle");
		this.update=new UpdateCommand();
	}
	public String helpText(){
		return " " + commandText + ": " + this.helpText;
	}

	@Override
	public boolean execute(Game game) {
		update.execute(game);
		game.computerAction();
		return true;
	}

	@Override
	public Command parse(String[] commandWords) throws CommandParseException {
		String option = commandWords[0].toUpperCase();
		if(option.equals("N")||option.equals("NONE") || option.isEmpty()){
			if(commandWords.length <= 1){
				return this;
			}
			else{
				throw new CommandParseException("Numero de argumentos incorrecto,\n recuerde: <none> o nada");
			}
		}
		else {return null;}
	}

}
