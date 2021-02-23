package tp.p3.Objects;

import tp.p3.ControllerAndManager.Game;

public abstract class ActiveGameObject extends GameObject{


	protected double frecuencia;
	protected int resistencia;
	protected int daño;
	protected int ciclos;
	
	public ActiveGameObject(Game game, int resistencia, String comportamiento, int ciclos, int maxCiclos, double frecuencia, int daño) {
		super(game, maxCiclos, comportamiento);
		this.resistencia = resistencia;
		this.frecuencia = frecuencia;
		this.daño = daño;
		this.ciclos = ciclos;
	}

	public abstract int getX();
	
	public abstract int getY();
	
	public abstract String dibujarElemento();
	
	public abstract void setX(int x);
	
	public abstract void setY(int y);
	
	public abstract int getResistencia();
	
	public abstract void setResistencia(int resistencia);
	
	public abstract double getFrecuencia();
	
	public abstract int getDannio();
	
	public abstract void setPosicionLista(int pos);
	
	public abstract int getCiclos();
	
	public abstract void setCiclos(int i);
	
	public abstract int getMaxCiclos();
	
	public abstract void establecerPos(int x, int y);
	
	public abstract String getNombre();
	
	public abstract boolean update();
}
