import { Action } from "./Action.js"
import { HttpRequest } from '../../modules/HttpRequest.js';

//Se obtiene la información que carga la pagina del detalle de proceso de admision actual
Action.fetchActiveData();

document.getElementById("downloadCsvBtn").addEventListener("click", function() {
    const url = '../../../api/get/generateCSV';

    // Hacer la solicitud para obtener el CSV
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('No se pudo generar el CSV');
            }
            return response.blob();
        })
        .then(blob => {
            const blobUrl = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = blobUrl;
            link.download = 'estudiantes_adminitidos.csv';
            document.body.appendChild(link);
            link.click();

            document.body.removeChild(link);
            window.URL.revokeObjectURL(blobUrl);
        })
        .catch(error => {
            console.error('Error al descargar el archivo CSV:', error);
        });
});
