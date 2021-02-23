package tp.p3.Command;

import tp.p3.ControllerAndManager.Game;
import tp.p3.Excepciones.CommandParseException;

public abstract class NoParamsCommand extends Command{

	public NoParamsCommand(String commandText, String commandInfo, String helpInfo) {
		super(commandText, commandInfo, helpInfo);
	}

	@Override
	public abstract boolean execute(Game game);

	@Override
	public abstract Command parse(String[] commandWords) throws CommandParseException;
	
}
