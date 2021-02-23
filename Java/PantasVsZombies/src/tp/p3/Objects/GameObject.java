package tp.p3.Objects;

import tp.p3.ControllerAndManager.Game;

public abstract class GameObject {
	protected int x;
	protected int y;
	protected int posLista;
	protected Game game;
	protected String comportamiento;
	protected int maxCiclos;
	
	public GameObject(Game game, int maxCiclos, String comportamiento) {
		this.game = game;	
		this.maxCiclos = maxCiclos;
		this.comportamiento = comportamiento;
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
	public abstract void setCiclos();
	public abstract int getMaxCiclos();
	public abstract void establecerPos(int x, int y);
	public abstract String getNombre();
	public abstract boolean update();
	
	
	public void añadirObjeto(GameObject elemento) {
		elemento.posLista = this.posLista;
		this.posLista++;
	}

	public int getNumElems() {
		return this.posLista;
	}

	public void setGame(Game game) {
		this.game=game;
	}	
}
