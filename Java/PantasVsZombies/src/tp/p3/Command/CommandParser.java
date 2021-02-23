package tp.p3.Command;


import tp.p3.Command.AddCommand;
import tp.p3.Command.ExitCommand;
import tp.p3.Command.HelpCommand;
import tp.p3.Command.ListCommand;
import tp.p3.Command.ResetCommand;
import tp.p3.Excepciones.CommandParseException;

public class CommandParser{

	private static Command [] availableCommands = {
		new ExitCommand(),
		new ResetCommand(),
		new HelpCommand(),
		new NoneCommand(),
		new ListCommand(),
		new AddCommand(),
		new CatchSunCommand(),
		new PrintModeCommand(),
		new ZombieListCommand(),
		new SaveCommand(),
		new LoadCommand()
	};

	public CommandParser() {}
	
	public static Command parseCommand(String[] words) throws CommandParseException, NumberFormatException {
		try{
			Command orden = null;
			for (Command op: availableCommands){
				orden = op.parse(words);
				if (orden != null) return orden;
			}
			return null;
		}
		catch(NumberFormatException e){
			throw e;
		}
		catch(CommandParseException e){
			throw e;
		}
	}
	
	public static String commandHelp(){
		String ayuda="";
		for (Command op: availableCommands){
			ayuda += op.helpText()+"\n";
		}
		return ayuda;
	}
}
