package tp.p3.Objects;

import tp.p3.ControllerAndManager.Game;

public class Sunflower extends Plant{
	
	//Constructor
	public Sunflower(Game game, int resistencia, String comportamiento, int coste, int ciclos, int maxCiclos, int frecuencia, int dannio){
		super(game, resistencia, comportamiento, coste, ciclos, maxCiclos, frecuencia, dannio);
	}

	public String dibujarElemento(){
		return "S ["+ this.resistencia+ "]";
	}
	
	public String getNombre() {
		return "S";
	}
	
	public boolean plantaMuerta(){
		return resistencia<=0;
	}
	
	public boolean puedoAñadirme(int soles){
		boolean ok=false;
			if(game.getScmanager().cobrarPlanta(this.coste)) {
				ok=true;
			}
		return ok;
	}
	
	public int getX() {
		return x;
	}
	
	public void setX(int x) {
		this.x = x;
	}
	
	public int getY() {
		return y;
	}
	
	public void setY(int y) {
		this.y = y;
	}
	
	public int getResistencia() {
		return resistencia;
	}
	
	public void setResistencia(int resistencia) {
		this.resistencia -= resistencia;
	}
	
	public int getCoste() {
		return this.coste;
	}
	
	public void setCoste(int coste) {
		this.coste = coste;
	}
	
	public double getFrecuencia() {
		return frecuencia;
	}
	
	public int getDannio() {
		return this.daño;
	}
	
	public int getCiclos() {
		return this.ciclos;
	}

	public void setCiclos() {
		this.ciclos += 1;
	}

	public void setPosicionLista(int pos) {
		this.posLista = pos;
	}
	
	public int getPosicionLista() {
		return this.posLista;
	}
	
	public void establecerPos(int x, int y) {
		this.x = x;
		this.y = y;
 	}

	public int getMaxCiclos() {
		return this.maxCiclos;
	}
	
	@Override
	public boolean update() {
		this.setCiclos();
		return ((this.ciclos % this.maxCiclos) == 0 && !this.plantaMuerta());
	}
	
	@Override
	public boolean estaEnRadio(int x, int y) {
		return true;
	}

	@Override
	public Plant getPlanta() {
		return this;
	}
}
