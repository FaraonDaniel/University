package tp.p3.Objects;

import tp.p3.ControllerAndManager.Game;

public class Nuez extends Plant{

	public Nuez(Game game, int resistencia, String comportamiento, int coste, int ciclos, int maxCiclos, int frecuencia, int dannio){
		super(game, resistencia, comportamiento, coste, ciclos, maxCiclos, frecuencia, dannio);
	}

	@Override
	public String dibujarElemento() {
		return "N ["+ this.resistencia+ "]";
	}
	
	public String getNombre() {
		return "N";
	}

	@Override
	public boolean plantaMuerta(){
		return this.resistencia<=0;
	}
	
	public boolean puedoAñadirme(int soles){
		boolean ok=false;
			if(game.getScmanager().cobrarPlanta(coste)) {
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
	
	public String getComportamiento() {
		return comportamiento;
	}
	
	public void setComportamiento(String comportamiento) {
		this.comportamiento = comportamiento;
	}
	
	public int getCoste() {
		return coste;
	}
	
	public double getFrecuencia() {
		return frecuencia;
	}
	
	public int getDannio() {
		return this.daño;
	}

	public void setPosicionLista(int pos) {
		this.posLista = pos;
	}
	
	public int getPosicionLista() {
		return this.posLista;
	}
	
	public int getCiclos() {
		return this.ciclos;
	}

	public void setCiclos() {
		this.ciclos += 1;
	}

	@Override
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
		return (!this.plantaMuerta());
	}

	@Override
	public boolean estaEnRadio(int x, int y) {
		return true;
	}

	@Override
	public Plant getPlanta() {
		// TODO Auto-generated method stub
		return this;
	}
}
