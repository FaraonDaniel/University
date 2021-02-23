package tp.p3.Command;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;

import tp.p3.ControllerAndManager.Game;
import tp.p3.Excepciones.CommandExecuteException;
import tp.p3.Excepciones.CommandParseException;
import tp.p3.Excepciones.FileContentsException;
import tp.p3.util.MyStringUtils;

public class LoadCommand extends Command{
	private String filename;

	public LoadCommand() {
		super("[LD]oad","<load> <file>.dat","loads a file.");
	}

	@Override
	public boolean execute(Game game) throws CommandExecuteException, FileContentsException, IOException {
		
		try {
		if(MyStringUtils.isValidFilename(this.filename)){
			File file = new File(this.filename + ".dat");
				if(file.exists()){
					BufferedReader bb = new BufferedReader (new FileReader(file));
					game.load(bb);
					bb.close();
					System.out.println("Game successfully loaded from file " + this.filename + ".dat proporcionado por el usuario.");
					return true;
				}
				else {
				throw new CommandExecuteException("No existe ese fichero");
			}
		}
		else{
			throw new CommandExecuteException("El nombre del fichero no es valido");
		}
		} catch(FileContentsException e) {
			throw e;
		}
	}

	@Override
	public Command parse(String[] commandWords) throws CommandParseException {
		
		String option = commandWords[0].toUpperCase();
		if((option.equals("LD") || option.equals("LOAD"))){
			if(commandWords.length == 2){
				this.filename=commandWords[1];
				return this;
			}
			else{
				throw new CommandParseException("Numero de argumentos incorrecto,\n recuerde: <load> <file>.dat (No introducir el .dat)");
			}
		}
		return null;
	}

	@Override
	public String helpText() {
		return " " + commandText + ": " + this.helpText;
	}

}
