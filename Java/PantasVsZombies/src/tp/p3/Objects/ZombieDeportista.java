package tp.p3.Objects;

import tp.p3.ControllerAndManager.Game;

public class ZombieDeportista extends Zombie{

	public ZombieDeportista(Game game, int resistencia, String comportamiento, int ciclos, int maxCiclos, double frecuencia, int dannio){
		super(game, 2, "Anda y come muy rapido", 0, 1,frecuencia, 1);
	}
	
	public boolean update(){
		this.ciclos++;
		return true;
	}

	@Override
	public String dibujarElemento() {
		return "X ["+ this.resistencia+ "]";
	}

	@Override
	public int getResistencia() {
		return this.resistencia;
	}

	@Override
	public void setPosicionLista(int pos) {
		this.posLista = pos;
		
	}

	@Override
	public int getPosicionLista() {
		return this.posLista;
	}

	@Override
	public double getFrecuencia() {
		return this.frecuencia;
	}

	@Override
	public void setFrecuencia(int frecuencia) {
		this.frecuencia = frecuencia;
	}

	@Override
	public void setResistencia(int resistencia) {
		this.resistencia = resistencia;
	}

	@Override
	public int getDannio() {
		return this.daño;
	}

	@Override
	public double getVelocidad() {
		return 1;
	}

	@Override
	public Game getGame() {
		return this.game;
	}

	@Override
	public int getY() {
		return this.y;
	}

	@Override
	public void setY(int y) {
		this.y = y;
	}

	@Override
	public int getX() {
		return this.x;
	}

	@Override
	public void setX(int x) {
		this.x = x;
	}

	@Override
	public boolean zombieMuerto() {
		boolean resultado = false;
		if(this.resistencia <= 0)
			resultado = true;
		return resultado;
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
	public void establecerPos(int x, int y) {
		this.x = x;
		this.y = y;
	}

	@Override
	public String getNombre() {
		return "X";
	}

	
	public int getMaxCiclos() {
		return this.maxCiclos;
	}
	

}
