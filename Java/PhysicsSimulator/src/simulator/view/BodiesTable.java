package simulator.view;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;

import javax.swing.BorderFactory;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.border.TitledBorder;

import simulator.control.Controller;


@SuppressWarnings("serial")
public class BodiesTable extends JPanel {
	
	private BodiesTableModel bodieModel;
	
	
	BodiesTable(Controller ctrl) {
		this.bodieModel = new BodiesTableModel(ctrl);
		JTable tabla = new JTable(this.bodieModel);
		setLayout(new BorderLayout());
		setBorder(BorderFactory.createTitledBorder(BorderFactory.createLineBorder(Color.black, 2), "Bodies",
				TitledBorder.LEFT, TitledBorder.TOP));
		this.add(new JScrollPane(tabla));
		Dimension panelD = new Dimension(1150, 300);
		this.setPreferredSize(panelD);
	}
}
