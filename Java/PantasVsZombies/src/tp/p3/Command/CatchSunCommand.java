package tp.p3.Command;


import tp.p3.ControllerAndManager.Game;
import tp.p3.Excepciones.CommandExecuteException;
import tp.p3.Excepciones.CommandParseException;

public class CatchSunCommand extends Command{

	int x;
	int y;
	private UpdateCommand update;
	
	public CatchSunCommand() {
		super("[C]atch ", "<catch> <x> <y>", "catch a sun");
		this.update=new UpdateCommand();
	}

	@Override
	public boolean execute(Game game) throws CommandExecuteException {
		if(!game.estaDentroTableroSoles(this.x,this.y)){
			throw new CommandExecuteException ("Esa casilla no existe");
		}
		update.execute(game);
		game.recogerSol(x, y);
		game.computerAction();
		return true;
	}

	@Override
	public Command parse(String[] commandWords) throws CommandParseException, NumberFormatException {
		try {
			boolean uno = (commandWords[0].toUpperCase().equals("C") || commandWords[0].toUpperCase().equals("CATCH"));
			if(!uno){
				return null;
			}
			else{
				if(commandWords.length==3){
					this.x = Integer.parseInt(commandWords[1]);
					this.y = Integer.parseInt(commandWords[2]);
					return this;
				}
				else {
					throw new CommandParseException("Numero de argumentos incorrecto,\n recuerde: <catch> <x> <y>");
				}
			}
		}
		catch(NumberFormatException e){
			throw e;
		}
		catch(CommandParseException e){
			throw e;
		}
		
		
	}

	@Override
	public String helpText() {
		return " " + commandText + ": " + this.helpText;
	}

}
