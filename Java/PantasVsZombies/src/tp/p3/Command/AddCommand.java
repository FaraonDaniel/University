package tp.p3.Command;

import tp.p3.ControllerAndManager.Game;
import tp.p3.ControllerAndManager.PlantsFactory;
import tp.p3.Excepciones.CommandExecuteException;
import tp.p3.Excepciones.CommandParseException;
import tp.p3.Objects.Plant;


public class AddCommand extends Command{
	private Plant plant;
	private UpdateCommand update;
	int x;
	int y;
	public AddCommand(String commandText, String commandInfo, String helpInfo) {
		super(commandText, commandInfo, helpInfo);		
	}
	
	public AddCommand() {
		super("[A]dd","<add> <plant> <x> <y>","add flower.");
		this.update=new UpdateCommand();
	}
	
	public String helpText(){
		return " " + commandText + ": " + this.helpText;
	}
	
	@Override
	public boolean execute(Game game) throws CommandExecuteException {
		try{
			if(condicionJuego(game)){
				update.execute(game);
				this.plant.setGame(game);
				this.plant.setX(x);
				this.plant.setY(y);
				game.añadir(this.plant, x, y);
				game.computerAction();
				return true;
			}
			else{
				return false;
			}
		}
		catch(CommandExecuteException e){
			throw e;
		}
	}

	@Override
	public Command parse(String[] commandWords) throws CommandParseException, NumberFormatException {
		boolean uno = (commandWords[0].toUpperCase().equals("A") || commandWords[0].toUpperCase().equals("ADD"));
		if(uno){
			if(commandWords.length == 4){
				if(inicial(commandWords[1]) == null){
					throw new CommandParseException("No existe ese tipo de planta,\n recuerde: [P]eashooter o [S]unflower o [C]herryBomb o [W]allNut");
				}
				try{
					this.x= Integer.parseInt(commandWords[2]);
					this.y= Integer.parseInt(commandWords[3]);
					return this;
				}
				catch(NumberFormatException e){
					throw e;
				}
			}
			else{
				throw new CommandParseException("Numero de argumentos incorrecto,\n recuerde: <add> <plant> <x> <y>");
			}
		}
		else{
			return null;
		}
		
	}
	
	
	private boolean condicionJuego(Game game) throws CommandExecuteException{
		boolean uno = game.plantaEstaDentroTablero(this.x, this.y);
		if(!uno){
			throw new CommandExecuteException("No esta dentro del tablero");
		}
		boolean dos = !game.hayAlguien(this.x,this.y);;
		if(!dos){
			throw new CommandExecuteException("Existe alguien en esa posicion");
		}
		boolean tres = game.getScmanager().getSolesDePartida() >= this.plant.getCoste();
		if(!tres){
			throw new CommandExecuteException("No tienes soles suficientes");
		}
		return uno && dos && tres;
	}
	
	
	private String inicial(String planta){
		if(planta.equals("S")||planta.equals("SUNFLOWER")){
			this.plant = PlantsFactory.getPlant(planta);
			return "S";
		}
		if(planta.equals("P") || planta.equals("PEASHOOTER")){
			this.plant = PlantsFactory.getPlant(planta);
			return "P";
		}
		if(planta.equals("C") || planta.equals("PETACEREZA")){
			this.plant = PlantsFactory.getPlant(planta);
			return "C";
		}
		if(planta.equals("N") || planta.equals("NUEZ")){
			this.plant = PlantsFactory.getPlant(planta);
			return "N";
		}
		return null;
	}

}