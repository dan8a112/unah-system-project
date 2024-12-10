import { makeTimeLine, separateData } from '../../admission/home_administration/Action.js';
import { HttpRequest } from '../../modules/HttpRequest.js';

const url = '../../../api/get/homeAPA/';

const data = { 
    "previousProcesses": [
            {
                "year": 2023,
                "processes": [
                    {
                        "id": 3,
                        "title": "1 Proceso 2023"
                    },
                    {
                        "id": 4,
                        "title": "2 Proceso 2023"
                    }
                ]
            },
            {
                "year": 2022,
                "processes": [
                    {
                        "id": 1,
                        "title": "1 Proceso 2022"
                    },
                    {
                        "id": 2,
                        "title": "2 Proceso 2022"
                    }
                ]
            }
        ]}

async function loadData() {
  // Realizar la solicitud GET usando HttpRequest
  //const respose = await HttpRequest.get(url);
  //const data = respose.data;
  console.log(data)

  if (data) {
    // Generar la línea de tiempo
    if (data.previousProcesses) {
      makeTimeLine(data.previousProcesses);
    }
  } else {
    console.error("No se pudo cargar la información desde la API.");
  }
}

// Llamar a la función para cargar los datos al iniciar el módulo
loadData();




