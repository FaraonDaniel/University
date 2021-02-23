package tp.p3.Excepciones;

public class FileContentsException extends Exception{

private static final long serialVersionUID = 1L;
	public FileContentsException() {
		super();
	}
	
	public FileContentsException(String mensaje) {
		super(mensaje);
	}
}
