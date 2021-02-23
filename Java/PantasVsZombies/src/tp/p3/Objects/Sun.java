package tp.p3.Objects;

import tp.p3.ControllerAndManager.Game;

public class Sun extends PasiveGameObject{
	private int ciclos;
	private static int valorSol = 10;

	
	public Sun(Game game, int maxCiclos, String comportamiento) {
		super(game, maxCiclos, comportamiento);
		this.ciclos = 0; 
	}


	@Override
	public int getX() {
		return this.x;
	}


	@Override
	public int getY() {
		return this.y;
	}


	@Override
	public String dibujarElemento() {
		return "*";
	}


	@Override
	public void setX(int x) {
		this.x = x;		
	}


	@Override
	public void setY(int y) {
		this.y = y;
		
	}


	@Override
	public int getResistencia() {
		return 0;
	}


	@Override
	public void setResistencia(int resistencia) {	
	}


	@Override
	public double getFrecuencia() {
		return 0;
	}


	@Override
	public int getDannio() {
		return 0;
	}


	@Override
	public void setPosicionLista(int pos) {	
		this.posLista = pos;
	}


	@Override
	public int getCiclos() {
		return this.ciclos;
	}


	@Override
	public void setCiclos() {
		this.ciclos++;
	}


	@Override
	public int getMaxCiclos() {
		return this.maxCiclos;
	}


	@Override
	public void establecerPos(int x, int y) {
		this.setX(x);
		this.setY(y);
	}


	@Override
	public String getNombre() {
		return "*";
	}


	@Override
	public boolean update() {
		this.ciclos++;
		return ((this.ciclos % maxCiclos) == 0);
	}

	
	public int getValor() {
		return Sun.valorSol;
	}
}
