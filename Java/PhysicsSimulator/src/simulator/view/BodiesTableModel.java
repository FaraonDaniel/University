package simulator.view;


import java.util.ArrayList;
import java.util.List;

import javax.swing.SwingUtilities;
import javax.swing.table.AbstractTableModel;

import simulator.control.Controller;
import simulator.model.Body;
import simulator.model.SimulatorObserver;

@SuppressWarnings("serial")
public class BodiesTableModel extends AbstractTableModel implements SimulatorObserver {
	//private BodiesTable bodiesStyle;
	private List<Body> _bodies;
	private String []columns= {"id", "Mass", "Position", "Velocity", "Acceleration"};
	
	
	BodiesTableModel(Controller ctrl) {
		_bodies = new ArrayList<>();
		ctrl.addObserver(this);

	}

	@Override
	public int getRowCount() {
		return _bodies.size();
	}

	@Override
	public int getColumnCount() {
		return this.columns.length;
	}

	@Override
	public String getColumnName(int column) {
		return this.columns[column];
	}


	public Object getValueAt(int rowIndex, int columnIndex) {
		 Body aux = this._bodies.get(rowIndex);
		 String valor = getColumnName(columnIndex);
		 
		 switch (valor) {
			case "id":
				return aux.getId();
			case "Mass":
				return aux.getMass();
			case "Position":
				return aux.getPosition();
			case "Velocity":
				return aux.getVelocity();
			case "Acceleration":
				return aux.getAcceleration();
			}
		 return null;
	}


	// ...
	@Override
	public void onRegister(List<Body> bodies, double time, double dt, String gLawsDesc) {
		this._bodies = bodies;
		SwingUtilities.invokeLater(new Runnable() {
			public void run() {
				fireTableStructureChanged();
			}
		});
		
	}

	@Override
	public void onReset(List<Body> bodies, double time, double dt, String gLawsDesc) {
		SwingUtilities.invokeLater(new Runnable() {
			public void run() {
				fireTableStructureChanged();
			}
		});
	}

	@Override
	public void onBodyAdded(List<Body> bodies, Body b) {
		this._bodies = bodies;
		SwingUtilities.invokeLater(new Runnable() {
			public void run() {
				fireTableStructureChanged();
			}
		});
	}

	@Override
	public void onAdvance(List<Body> bodies, double time) {
		this._bodies = bodies;
		SwingUtilities.invokeLater(new Runnable() {
			public void run() {
				fireTableStructureChanged();
			}
		});
	}

	@Override
	public void onDeltaTimeChanged(double dt) {
	}

	@Override
	public void onGravityLawChanged(String gLawsDesc) {
	}
}
