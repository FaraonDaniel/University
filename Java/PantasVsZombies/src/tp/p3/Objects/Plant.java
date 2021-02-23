package tp.p3.Objects;

import java.io.BufferedWriter;
import java.io.IOException;

import tp.p3.ControllerAndManager.Game;


public abstract class Plant extends ActiveGameObject{
	
	protected int coste;
	public static int SOLES_SUNFLOWER = 10;
	
	public Plant(Game game, int resistencia, String comportamiento, int coste, int ciclos, int maxCiclos, int frecuencia, int daño){
		super(game, resistencia, comportamiento, 0, maxCiclos, frecuencia, daño);
		this.resistencia = resistencia; 
		this.coste = coste;
	}
	
	public abstract String dibujarElemento();
	
	public abstract String getNombre();
	
	public abstract boolean plantaMuerta();
	
	public abstract boolean puedoAñadirme(int soles);
	
	public abstract int getX();
	
	public abstract void setX(int x);
	
	public abstract int getY();
	
	public abstract void setY(int y);
	
	public abstract int getResistencia();
	
	public abstract void setResistencia(int resistencia);
	
	public abstract int getCoste();
	
	public abstract double getFrecuencia();
	
	public abstract int getDannio();

	public abstract void setPosicionLista(int pos);
	
	public abstract int getCiclos();

	public abstract void setCiclos();
	
	public abstract void establecerPos(int x, int y);
	
	public abstract int getMaxCiclos();
	
	public abstract boolean update();
	
	public abstract boolean estaEnRadio(int x, int y);
	
	public abstract Plant getPlanta();

	public void store(BufferedWriter buff) throws IOException {
		buff.write(this.getNombre() + ":" + this.getResistencia() + ":" + this.x + ":" + this.y + ":" + (this.getCiclos() % this.getMaxCiclos()));
	}

	public void setCiclos(int parseInt) {
		this.ciclos=parseInt;
		
	}
	
	public void setResistenciaInicial(int resistencia) {
		this.resistencia = resistencia;
	}

}
