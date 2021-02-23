package tp.p3.Printer;

import tp.p3.ControllerAndManager.Game;
import tp.p3.ControllerAndManager.SunManager;
import tp.p3.Objects.Plant;
import tp.p3.Objects.Zombie;

public abstract class BoardPrinter implements GamePrinter{

	protected int cellSize = 7;
	protected String space = " ";
	protected String hDelimiter = "-";
	protected String vDelimiter = "|";
	protected String [][] tablero;
	protected Game game;
	protected SunManager sunMan;
	private DebugPrinter debug;
	private ReleasePrinter releaseprinter;
	
	public BoardPrinter(int fila, int columna, Game game, SunManager sunMan) {
		this.game = game;
		this.tablero = new String[fila][columna];
		this.sunMan = sunMan;
	}
	
	public abstract void imprimirDatos();
	
	public abstract void encodeGame(Game game);
	
	public abstract void hacerRayas(int n);
	
	public abstract Plant esPlanta(int x, int y);
	
	public abstract Zombie esZombie(int x, int y);
	
	public void toRelease(Game game) {
		this.releaseprinter.encodeGame(game);
	}
	
	public void toDebug(Game game) {
		this.debug.encodeGame(game);
	}
	
}
