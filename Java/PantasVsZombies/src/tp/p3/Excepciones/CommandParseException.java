package tp.p3.Excepciones;

public class CommandParseException extends Exception {
	private static final long serialVersionUID = 1L;
	
	CommandParseException(){
		super();
	}
	
	public CommandParseException(String message){
		super(message);
	}
	
}
