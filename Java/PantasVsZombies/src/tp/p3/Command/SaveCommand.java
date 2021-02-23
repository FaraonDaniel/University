package tp.p3.Command;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import tp.p3.ControllerAndManager.Game;
import tp.p3.Excepciones.*;
import tp.p3.util.MyStringUtils;

public class SaveCommand extends Command{
	
	private String nombreFile;
	
	public SaveCommand() {
		super("[S]ave","<save> <file>","saves a file.");
	}

	@Override
	public String helpText() {
		return " " + commandText + ": " + this.helpText;
	}

	@Override
	public boolean execute(Game game) throws CommandExecuteException, IOException, FileContentsException {
		boolean resultado = false;
		if(MyStringUtils.isValidFilename(this.nombreFile)) {
			File fichero = new File(this.nombreFile);
			if(fichero.exists()) {
				fichero.delete();
			}
			BufferedWriter buff = new BufferedWriter(new FileWriter(new File(nombreFile)));
			game.store(buff);
			resultado = true;
			
			buff.close();
			
			System.out.println("Game successfully saved in file <" + this.nombreFile + ">.dat. Use the load command to reload it.");
		}
		else
			throw new CommandExecuteException("Fichero con nombre erroneo.");
		return resultado;
		
	}

	@Override
	public Command parse(String[] commandWords) throws CommandParseException, NumberFormatException {
		if(commandWords[0].equals("S") || commandWords[0].equals("SAVE")) {
			if(commandWords.length == 2) {
				this.nombreFile = commandWords[1] + ".dat";
				return this;
			}
			else
				throw new CommandParseException("Numero de argumentos incorrectos,\n recuerde: <save> <file> (la extension ya se introduce por defecto)");
		}
		else
			return null;
	}

}
