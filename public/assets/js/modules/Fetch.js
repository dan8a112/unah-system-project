/**
 * Esta función se encarga de realizar una solicitud HTTP (fetch) para obtener datos de una URL específica.
 * Se maneja la respuesta y los posibles errores de la solicitud de forma estructurada.
 * 
 * author: afcastillof@unah.hn
 * version: 0.1.0
 * date: 6/11/24
 * 
 * @param {string} url La URL desde donde se realizará la solicitud de datos.
 * @returns {Object|null} Retorna los datos obtenidos en formato JSON si la solicitud es exitosa, o null en caso de error.
 * 
 * @throws {Error} Si la respuesta de la red no es válida o si los datos no son encontrados.
 */
export const fetchData = async (url) => {
  try {
    // Realiza la solicitud de datos a la URL proporcionada
    const response = await fetch(url);

    // Verifica si la respuesta fue correcta
    if (!response.ok) {
      throw new Error('La respuesta de la red no fue correcta ' + response.statusText);
    }

    // Convierte la respuesta a formato JSON
    const data = await response.json();

    // Si los datos fueron obtenidos, los retorna
    if (data) {
      return data; 
    }

    // Si no se encontraron datos, lanza un error
    throw new Error('Datos no encontrados');
  } catch (error) {
    // Maneja cualquier error que ocurra durante la solicitud
    console.error('Error al realizar el fetch:', error);
    return null;
  }
};
