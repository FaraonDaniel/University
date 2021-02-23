package tp.p3.Objects;

import tp.p3.ControllerAndManager.Game;

public class PetaCereza extends Plant{

	public PetaCereza(Game game, int resistencia, String comportamiento, int coste, int ciclos, int maxCiclos, int frecuencia, int dannio){
		super(game, resistencia, comportamiento, coste, ciclos, maxCiclos, frecuencia, dannio);
	}

	@Override
	public String dibujarElemento() {
		return "C ["+ this.resistencia+ "]";
	}
	
	public String getNombre() {
		return "C";
	}

	@Override
	public boolean plantaMuerta() {
		return this.resistencia<=0;
	}

	@Override
	public boolean puedoAñadirme(int soles) {
		boolean ok=false;
		if(game.getScmanager().cobrarPlanta(coste)) {
			ok=true;
		}
	return ok;
	}

	public int getX() {
		return this.x;
	}
	
	public void setX(int x) {
		this.x = x;
	}
	
	public int getY() {
		return this.y;
	}
	
	public void setY(int y) {
		this.y = y;
	}
	
	public int getResistencia() {
		return this.resistencia;
	}
	
	public void setResistencia(int resistencia) {
		this.resistencia -= resistencia;
	}
	
	public String getComportamiento() {
		return this.comportamiento;
	}
	
	public void setComportamiento(String comportamiento) {
		this.comportamiento = comportamiento;
	}
	
	public int getCoste() {
		return this.coste;
	}
	
	public double getFrecuencia() {
		return this.frecuencia;
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
	
	public boolean update() {
		this.setCiclos();
		return ((this.ciclos % this.maxCiclos) == 0 && !this.plantaMuerta());
	}
	
	public boolean estaEnRadio(int x, int y){
		boolean resultado = false;
		if(x == this.x-1 || x == this.x || x == this.x+1){
			if(y == this.y || y == this.y+1 || y == this.y-1){
				resultado = true;
			}
		}
		return resultado;
	}
	
	public boolean explota() {
		return ((this.ciclos % this.maxCiclos) == 0);
	}

	@Override
	public Plant getPlanta() {
		// TODO Auto-generated method stub
		return this;
	}
	
}
