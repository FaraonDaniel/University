package tp.p3.Excepciones;

public class ExceptionArgs extends Exception{

	private static final long serialVersionUID = 1L;

	ExceptionArgs(){
		super();
	}
	
	public ExceptionArgs(String message){
		super(message);
	}
}
