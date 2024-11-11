/**
 * Esta clase contiene logica relacionada con la implementacion de graficos
 * @param canvasId este es el id de la etiqueta canvas que tenemos en nuestro html
 * @param data este es un arreglo numerico de la informacion que estara en el eje y
 * @param labels este es un arreglo de etiquetas que estaran en el eje x
* author: afcastillof@unah.hn
* version: 0.1.1
* date: 11/11/24
 * 
 */
class BarChart {
  constructor(canvasId, data, labels) {
    this.canvas = document.getElementById(canvasId);
    this.ctx = this.canvas.getContext("2d");
    this.data = data;
    this.labels = labels;

    // Configuración del gráfico
    this.padding = 10;
    this.barWidth = 30;
    this.barSpacing = 30;
    this.barMargin = 20;
    this.offsetX = 60;
    this.offsetY = 20;
    this.dpr = window.devicePixelRatio || 1;
    this.chartTitle = "Grafico de aspirantes en procesos";
    this.chartSubtitle = "Datos recolectados en el primer semestre";

    // Calcular dimensiones del canvas y del gráfico
    this.chartHeight = 250;
    this.chartWidth = (this.barWidth + this.barSpacing) * this.data.length;
    this.canvas.width = (this.chartWidth + this.offsetX + this.barMargin + this.padding * 2) * this.dpr;
    this.canvas.height = (this.chartHeight + this.padding * 2) * this.dpr;
    this.canvas.style.width = `${this.chartWidth + this.offsetX + this.barMargin + this.padding * 2}px`;
    this.canvas.style.height = `${this.chartHeight + this.padding * 2}px`;

    // Escalar el contexto
    this.ctx.scale(this.dpr, this.dpr);
  }

  draw() {
    // Dibujar el título
    this.ctx.fillStyle = "black";
    this.ctx.font = "18px Roboto";
    this.ctx.textAlign = "center";
    this.ctx.fillText(this.chartTitle, this.canvas.width / (2 * this.dpr), 30);

    const maxValue = Math.max(...this.data);
    const roundedMaxValue = Math.ceil(maxValue / 10) * 10;
    const numYLabels = 5;
    const labelHeightScale = (this.chartHeight - this.offsetY * 5) / this.chartHeight;

    // Dibujar las etiquetas del eje Y
    for (let i = 0; i <= numYLabels; i++) {
      const y = this.offsetY + (this.chartHeight - (this.chartHeight / numYLabels) * i) * labelHeightScale;
      const labelValue = Math.ceil((Math.round((roundedMaxValue / numYLabels) * i)) / 10) * 10;

      this.ctx.fillStyle = "#C4C4C4";
      this.ctx.font = "12px Arial";
      this.ctx.fillText(labelValue, this.offsetX - 35, y + 60);
    }

    // Dibujar el gráfico de barras
    this.data.forEach((value, index) => {
      const barHeight = (value / maxValue) * (this.chartHeight - this.offsetY * 5);
      const x = this.offsetX + this.barMargin + index * (this.barWidth + this.barSpacing);
      const y = this.chartHeight - barHeight - this.offsetY;

      this.ctx.fillStyle = "#FFAA34";
      this.ctx.fillRect(x, y, this.barWidth, barHeight);

      // Agregar etiquetas en el eje X
      this.ctx.fillStyle = "#C4C4C4";
      this.ctx.font = "14px Arial";
      this.ctx.fillText(this.labels[index], x + this.barWidth / 4, this.chartHeight - 5);
    });

    // Dibujar el eje Y
    this.ctx.beginPath();
    this.ctx.moveTo(this.offsetX, this.offsetY - 10);
    this.ctx.lineTo(this.offsetX, this.chartHeight - this.offsetY);
    this.ctx.strokeStyle = "black";
    this.ctx.stroke();

    // Dibujar el eje X
    this.ctx.beginPath();
    this.ctx.moveTo(this.offsetX, this.chartHeight - this.offsetY);
    this.ctx.lineTo(this.chartWidth + this.offsetX + this.barMargin, this.chartHeight - this.offsetY);
    this.ctx.strokeStyle = "black";
    this.ctx.stroke();
  }
}

export {BarChart}

// ctx.font = "16px Arial";
// ctx.fillStyle = "black";
// ctx.fillText(chartSubtitle, canvas.width / (2 * dpr), canvas.height / dpr - 20);