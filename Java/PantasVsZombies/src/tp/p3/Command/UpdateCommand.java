package tp.p3.Command;


import tp.p3.ControllerAndManager.Game;

public class UpdateCommand extends NoParamsCommand{

	public UpdateCommand(String commandText, String commandInfo, String helpInfo) {
		super(commandText, commandInfo, helpInfo);
	}
	
	public UpdateCommand() {
		super("Update","","Update the game");
	}
	
	public String helpText(){
		return " " + commandText + ": " + this.helpText;
	}

	@Override
	public boolean execute(Game game) {
		game.update();
		return true;
	}

	@Override
	public Command parse(String[] commandWords) {
		return null;
	}

}
