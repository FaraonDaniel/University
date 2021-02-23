package tp.p3.Objects;
import java.io.BufferedWriter;
import java.io.IOException;

import tp.p3.ControllerAndManager.*;

public class ListZombies {
	

	private Zombie []listZombies;
	private int contadorZombie;
	
	public ListZombies() {
		this.listZombies = new Zombie[Game.FILAS * Game.COLUMNAS - 1];
		this.contadorZombie = 0;
	}
	
	
	
	
	public ListZombies(int contadorZombie2) {
		this.listZombies = new Zombie[contadorZombie2];
		this.contadorZombie = 0;
	}



	public void añadirZombie(Zombie tipo, int x, int y) {
		this.listZombies[contadorZombie] = tipo;
		this.listZombies[contadorZombie].x = x;
		this.listZombies[contadorZombie].y = y;
		this.contadorZombie++;
	}
	
	public int getContadorZombies() {
		return this.contadorZombie;
	}
	public boolean ZombieGanador() {
		boolean resultado = false;
		for(int i =0; i < this.contadorZombie; i++) {
			if(this.listZombies[i].y == 0)
				resultado = true;
		}
		return resultado;
	}
	
	public boolean exiteZombie(int x, int y) {
		boolean resultado = false;
		for(int i =0; i < this.contadorZombie; i++) {
			if(this.listZombies[i].y == y && this.listZombies[i].x == x)
				resultado = true;
		}
		return resultado;
	}
	
	public void moverZombies() {
		for(int i = 0; i < this.contadorZombie; i++){
			if(!exiteZombie(listZombies[i].getX(), listZombies[i].getY()-1)){
				if(listZombies[i].update()){
				listZombies[i].setY(listZombies[i].getY()-1);
				}
			}
		}

	}
	
	
	public boolean esZombie(int x, int y, int indice) {
		boolean resultado = false;
		if(this.listZombies[indice].x == x && this.listZombies[indice].y == y)
			resultado = true;
		return resultado;
	}
	
	public void eliminarMuertos() {
		int i=0;
		while(i < this.contadorZombie){
			if(listZombies[i].getResistencia() <= 0){
				for(int j = i; j< this.contadorZombie - 1; j++){
					listZombies[j] = listZombies[j+1];
					listZombies[j+1] = null;
				}
				i--;
				this.contadorZombie--;
			}
			i++;
		}
	}
	
	public void recibeGolpes(int i, int golpes) {
		this.listZombies[i].resistencia -= golpes;
	}
	
	public void moverZombie(int i) {
		this.listZombies[i].y -= 1;
	}
	
	public Zombie[] getListZombies() {
		return listZombies;
	}
	
	public void store(BufferedWriter buff) throws IOException{
		
		for(int i = 0; i < this.contadorZombie; i++){
			this.listZombies[i].store(buff);
			if(i != this.contadorZombie-1){
				buff.write(", ");
			}
		}
		buff.write("\n");
	}




	public void añadirZombie(Zombie zomb) {
		this.listZombies[this.contadorZombie] = zomb;
		this.contadorZombie++;
		
	}
}

