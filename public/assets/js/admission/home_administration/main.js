import {BarChart} from './chart.js'
// Crear una instancia de la clase y dibujar el gráfico
const data = [120, 80, 150, 200, 90, 130, 321];
const labels = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul"];
const barChart = new BarChart("admissionChart", data, labels);
barChart.draw();