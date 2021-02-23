package tp.p3.ControllerAndManager;

import tp.p3.Objects.Sun;

public class SunManager {
	
	private int solesDePartida = 50;
	private Sun [] arraySoles;
	private int contadorSoles;
	
	
	public SunManager(Game game) {
		this.arraySoles = new Sun[game.getLimiteFilas() * game.getLimiteColumnas() - 1];
		this.contadorSoles = 0;
	}
	
	public int getSolesDePartida() {
		return solesDePartida;
	}
	
	public void setSolesPartida(int x) {
		this.solesDePartida = x;
	}
	
	public void anniadirSoles(Sun solActual) {
		this.solesDePartida += solActual.getValor();
		
	}

	public boolean cobrarPlanta(int costePlanta) {
		boolean ok=false;
		if(costePlanta<=this.solesDePartida) {
			this.solesDePartida -= costePlanta;
			ok=true;
		}
		return ok;
	}
	
	public void addSun(Sun sun, int x, int y) {
			arraySoles[contadorSoles] = sun;
			contadorSoles++;
	}

	public boolean isPositionEmpty(int x, int y) {
		boolean resultado = true;
		for(int i = 0; i < this.contadorSoles; i++) {
			if(this.arraySoles[i].getX() == x && this.arraySoles[i].getY() == y)
				resultado = false;
		}
		return resultado;
	}
	
	public void recogerSol(int x, int y) {
		for(int i = 0; i < this.contadorSoles; i++) {
			if(this.arraySoles[i].getX() == x && this.arraySoles[i].getY() == y) {
				this.solesDePartida += this.arraySoles[i].getValor();
				eliminarSol(i);
			}
		}
	}
	
	/*public boolean existeSol(int x, int y) {
		boolean resultado = false;
		for(int i = 0; i < this.contadorSoles; i++) {
			if (arraySoles[i].getX() == x && arraySoles[i].getY() == y)
				resultado = true;
		}
		return resultado;
	}
	*/
	public void eliminarSol(int indice) {
		for(int i = indice; i < this.contadorSoles; i++) {
			arraySoles[i] = arraySoles[i+1];
			arraySoles[i+1] = null;
		}
		this.contadorSoles--;
	}
	
	public Sun[] getArraySoles() {
		return this.arraySoles;
	}
}
