package tp.p3.Command;


import tp.p3.ControllerAndManager.Game;
import tp.p3.Excepciones.CommandParseException;
import tp.p3.Printer.DebugPrinter;
import tp.p3.Printer.GamePrinter;
import tp.p3.Printer.ReleasePrinter;

public class PrintModeCommand extends Command {
	private boolean noPrint;

	public PrintModeCommand(String commandText, String commandInfo, String helpInfo) {
		super(commandText, commandInfo, helpInfo);
		noPrint=false;
	}
	
	public PrintModeCommand() {
		super("[P]rintMode","<PrintMode> <mode>","change print mode [Release|Debug]");
	}
	
	public String helpText(){
		return " " + commandText + ": " + this.helpText;
	}
	
	@Override
	public boolean execute(Game game) {
		game.setNoPrint(noPrint);
		if(!noPrint) {
			GamePrinter gamePrinter=new ReleasePrinter(Game.FILAS, Game.COLUMNAS, game, game.getScmanager());
			game.setGamePrinter(gamePrinter);
		}
		else {
			GamePrinter gamePrinter=new DebugPrinter(Game.FILAS, Game.COLUMNAS, game, game.getScmanager());
			game.setGamePrinter(gamePrinter);
		}
		return true;
	}
	public Command parse(String[] commandWords) throws CommandParseException{
		String option = commandWords[0].toUpperCase();
		if((option.equals("P") || option.equals("PRINTMODE"))){
			if(commandWords.length == 2){
				String option2 = commandWords[1].toUpperCase();
				if(condicion(option, option2)){
					if(option2.equals("DEBUG") || option2.equals("D")){
						this.noPrint=true;
					}
					if(option2.equals("RELEASE") || option2.equals("R")){
						this.noPrint=false;
					}
					return this;
				}
				else {
					throw new CommandParseException("No existe ese tipo de printer,\n recuerde: Release o Debug");
				}
			}
			else{
				throw new CommandParseException("Numero de argumentos incorrecto,\n recuerde: <PrintMode> <mode>");
			}
		}
		return null;
	}
	
	private boolean condicion(String option, String option2){
		return (option2.equals("RELEASE") || option2.equals("R") || option2.equals("DEBUG") ||  option2.equals("D"));
	}

}
