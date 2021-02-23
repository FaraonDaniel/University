package tp.p3.Objects;

import java.io.BufferedWriter;
import java.io.IOException;

import tp.p3.ControllerAndManager.*;

public class ListPlants {
	private Plant []listPlantas;
	private int contadorPlanta;
	
	public ListPlants() {
		this.listPlantas = new Plant[Game.FILAS * Game.COLUMNAS - 1];
		this.contadorPlanta = 0;
	}

	public void añadirPlanta(Plant plant, int x, int y) {
		this.listPlantas[this.contadorPlanta] = plant;
		this.listPlantas[this.contadorPlanta].x = x;
		this.listPlantas[this.contadorPlanta].y = y;
		this.contadorPlanta++;
	}
	
	
	public int getContadorPlantas() {
		return this.contadorPlanta;
	}
	
	
	public boolean exitePlanta(int x, int y) {
		boolean resultado = false;
		for(int i =0; i < this.contadorPlanta; i++) {
			if(this.listPlantas[i].y == y && this.listPlantas[i].x == x)
				resultado = true;
		}
		return resultado;
	}
	
	public boolean esGirasol(int i) {
		boolean resultado = false;
		if(this.listPlantas[i].update() && this.listPlantas[i].getNombre().equals("S"))
			resultado = true;
		
		return resultado;
		
	}
	
	public boolean realizaAccion(int i) {
		boolean resultado = false;
		
		if((this.listPlantas[i].ciclos % this.listPlantas[i].maxCiclos) == 0) {
			resultado = true;
		}
		return resultado;
	}
	
	public void eliminarMuertos() {
		int i=0;
		while(i < this.contadorPlanta){
			if(listPlantas[i].getResistencia() <= 0){
				for(int j = i; j< this.contadorPlanta - 1; j++){
					listPlantas[j] = listPlantas[j+1];
					listPlantas[j+1] = null;
				}
				i--;
				this.contadorPlanta--;
			}
			i++;
		}
	}
	
	public boolean esPlanta(int x, int y, int indice) {
		boolean resultado = false;
		if(this.listPlantas[indice].x == x && this.listPlantas[indice].y == y)
			resultado = true;
		return resultado;
	}
	
	public void recibeGolpe(int i, int golpe) {
		this.listPlantas[i].setResistencia(golpe);
	}
	
	public Plant [] getListPlants() {
		return this.listPlantas;
	}
	
	
	public void store(BufferedWriter buff) throws IOException{
		for(int i = 0; i < this.contadorPlanta; i++){
			this.listPlantas[i].store(buff);
			if(i != this.contadorPlanta-1){
				buff.write(", ");
			}
		}
		buff.write("\n");
	}

	public void añadirPlanta(Plant planta) {
		this.listPlantas[this.contadorPlanta]=planta;
		this.contadorPlanta++;		
	}
}
