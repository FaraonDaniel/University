package tp.p3.ControllerAndManager;

import tp.p3.Objects.Nuez;
import tp.p3.Objects.Peashooter;
import tp.p3.Objects.PetaCereza;
import tp.p3.Objects.Plant;
import tp.p3.Objects.Sunflower;

public abstract class PlantsFactory {
	private static final Plant Peashooter = new Peashooter(null, 3, "Dispara guisantes", 50, 0, 1, 0, 1);
	private static final Plant Sunflower = new Sunflower(null, 1, "Genera soles", 20, 0, 2, 0, 0);
	private static final Plant CherryBomb = new PetaCereza(null, 2, "Explota en area", 50, 0, 2, 0, 10);
	private static final Plant WallNut = new Nuez(null, 10, "Aguanta golpes", 50, 0, 1, 0, 0);
	
	public PlantsFactory(Game game) {
	}
	
	public static Plant getPlant(String plantName){
		Plant resultado = null;
		
		if(plantName.equals("PEASHOOTER") || plantName.equals("P"))
			resultado = new Peashooter(null, 3, "Dispara guisantes", 50, 0, 1, 0, 1);
		else if(plantName.equals("SUNFLOWER") || plantName.equals("S"))
			resultado = new Sunflower(null, 1, "Genera soles", 20, 0, 2, 0, 0);
		else if(plantName.equals("PETACEREZA") || plantName.equals("C"))
			resultado = new PetaCereza(null, 2, "Explota en area", 50, 0, 2, 0, 10);
		else if(plantName.equals("NUEZ") || plantName.equals("N"))
			resultado = new Nuez(null, 10, "Aguanta golpes", 50, 0, 1, 0, 0);
		return resultado;
	}
	
	public static String listOfAvilablePlants() {
		String lista = "";
		lista += "[P]eashooter: Coste: " + Peashooter.getCoste() + " suncoins Harm: " + Peashooter.getDannio() + "\n";
		lista += "[S]unflower: Coste: " + Sunflower.getCoste() + " suncoins Harm: " + Sunflower.getDannio() + "\n";	
		lista += "[C]herryBomb: Coste: " + CherryBomb.getCoste() + " suncoins Harm: " + CherryBomb.getDannio() + "\n";
		lista += "[W]allNut: Coste: " + WallNut.getCoste() + " suncoins Harm: " + WallNut.getDannio() + "\n";
		
		return lista;
	}
		
}
