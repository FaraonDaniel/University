package tp.p3.Excepciones;

public class CommandExecuteException extends Exception {
	private static final long serialVersionUID = 1L;
	
	CommandExecuteException(){
		super();
	}
	
	public CommandExecuteException(String message){
		super(message);
	}

}
