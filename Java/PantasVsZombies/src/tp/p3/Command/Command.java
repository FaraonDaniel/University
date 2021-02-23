package tp.p3.Command;


import java.io.IOException;

import tp.p3.ControllerAndManager.Game;
import tp.p3.Excepciones.CommandExecuteException;
import tp.p3.Excepciones.CommandParseException;
import tp.p3.Excepciones.FileContentsException;

public abstract class Command {
		protected String helpText;
		protected String commandText;
		protected final String commandName;
		
		
		public Command(String commandText, String commandInfo, String helpInfo){
		this.commandText = commandText;
		helpText = helpInfo;
		String[] commandInfoWords = commandInfo.split("\\s+");
		commandName = commandInfoWords[0];
		}
		
		//Ejecuta el comando correspondiente.
		public abstract boolean execute(Game game) throws CommandExecuteException, IOException, FileContentsException;
		
		//Parsea la informacion de cada comando.
		public abstract Command parse(String[] commandWords) throws CommandParseException, NumberFormatException;
		
		//Devuelve la ayuda del comando.
		public abstract String helpText();
}
