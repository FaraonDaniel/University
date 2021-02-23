package simulator.view;

import java.awt.BasicStroke;
import java.awt.Color;
import java.awt.Graphics;
import java.awt.Graphics2D;
import java.awt.RenderingHints;
import java.awt.event.KeyEvent;
import java.awt.event.KeyListener;
import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;
import java.util.ArrayList;
import java.util.List;
import javax.swing.JComponent;
import javax.swing.SwingUtilities;

import simulator.control.Controller;
import simulator.misc.Vector;
import simulator.model.Body;
import simulator.model.SimulatorObserver;

@SuppressWarnings("serial")
public class Viewer extends JComponent implements SimulatorObserver{

	private int _centerX;
	private int _centerY;
	private double _scale;
	private List<Body> _bodies;
	private boolean _showHelp;

	Viewer(Controller ctrl) {
		initGUI();
		ctrl.addObserver(this);
	}

	private void initGUI() {
		_bodies = new ArrayList<>();
		_scale = 1.0;
		addKeyListener(new KeyListener() {
			public void keyPressed(KeyEvent e) {
				switch (e.getKeyChar()) {
				case '-':
				_scale = _scale * 1.1;
				break;
				case '+':
				_scale = Math.max(1000.0, _scale / 1.1);
				break;
				case '=':
				autoScale();
				break;
				case 'h':
				_showHelp = ! _showHelp;
				break;
				default:
				}
			repaint();
			}
			@Override
			public void keyTyped(KeyEvent e) {
			}
			@Override
			public void keyReleased(KeyEvent e) {
			}
		});
		addMouseListener(new MouseListener() {

			@Override
			public void mouseEntered(MouseEvent e) {
			requestFocus();
			}
			@Override
			public void mouseClicked(MouseEvent e) {
			}
			@Override
			public void mousePressed(MouseEvent e) {
			}
			@Override
			public void mouseReleased(MouseEvent e) {
			}
			@Override
			public void mouseExited(MouseEvent e) {
			}
		});
	}

	@Override
	protected void paintComponent(Graphics g) {
		super.paintComponent(g);
		Graphics2D gr = (Graphics2D) g;
		gr.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);
		gr.setRenderingHint(RenderingHints.KEY_TEXT_ANTIALIASING, RenderingHints.VALUE_TEXT_ANTIALIAS_ON);
		_centerX = getWidth() / 2;
		_centerY = getHeight() / 2;
		gr.drawLine(_centerX-3, _centerY, _centerX+3, _centerY);
		gr.drawLine(_centerX, _centerY-3, _centerX, _centerY+3);
	
		
		for (Body body : _bodies) {
			gr.setStroke(new BasicStroke(3));
			gr.setColor(Color.blue);
			gr.fillOval(_centerX + (int)(body.getPosition().coordinate(0)/_scale), (_centerY + (int)(body.getPosition().coordinate(1)/_scale)), 8, 8);
			gr.drawString(body.getId(), _centerX + (int)(body.getPosition().coordinate(0)/_scale), (_centerY + (int)(body.getPosition().coordinate(1)/_scale)-20));
		}
		
		if(_showHelp == true) {
			
			gr.setColor(Color.red);
			gr.drawString("h:toggle help, +:zoom-in, -:zoom-out, =:fit", 7, 33);
			gr.drawString("Scaling ratio: " + this._scale, 7, 50);
		}
	}

	
	private void autoScale() {
		double max = 1.0;
		for (Body b : _bodies) {
			Vector p = b.getPosition();
			for (int i = 0; i < p.dim(); i++)
				max = Math.max(max,
				Math.abs(b.getPosition().coordinate(i)));
		}
		double size = Math.max(1.0, Math.min((double) getWidth(), (double) getHeight()));
		_scale = max > size ? 4.0 * max / size : 1.0;
	}

	@Override
	public void onRegister(List<Body> bodies, double time, double dt, String gLawsDesc) {
		this._bodies = bodies;
		SwingUtilities.invokeLater(new Runnable() {
			public void run() {
				autoScale();
				repaint();
			}
		});
		
	}

	@Override
	public void onReset(List<Body> bodies, double time, double dt, String gLawsDesc) {
		this._bodies = bodies;
		SwingUtilities.invokeLater(new Runnable() {
			public void run() {
				autoScale();
				repaint();
			}
		});
	}

	@Override
	public void onBodyAdded(List<Body> bodies, Body b) {
		this._bodies = bodies;
		SwingUtilities.invokeLater(new Runnable() {
			public void run() {
				autoScale();
				repaint();
			}
		});
	}

	@Override
	public void onAdvance(List<Body> bodies, double time) {
		this._bodies = bodies;
		SwingUtilities.invokeLater(new Runnable() {
			public void run() {
				repaint();
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
