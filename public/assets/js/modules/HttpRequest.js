/**
 * Esta clase proporciona métodos para realizar solicitudes HTTP GET y POST.
 * En el caso de POST, usa un formulario HTML para enviar los datos.
 * 
 * author: afcastillof@unah.hn
 * version: 0.1.1
 * date: 7/11/24
 */
export class HttpRequest {
  
  /**
   * Realiza una solicitud GET a la URL especificada.
   * @param {string} url 
   * @returns {Object|null} 
   * @throws {Error} 
   */
  static async get(url) {
    try {
      const response = await fetch(url);
      if (!response.ok) {
        throw new Error('La respuesta de la red no fue correcta ' + response.statusText);
      }
      const data = await response.json();
      if (data) {
        return data;
      }
      throw new Error('Datos no encontrados');
    } catch (error) {
      console.error('Error al realizar la solicitud GET:', error);
      return null;
    }
  }

  /**
   * Realiza una solicitud POST a la URL especificada usando los datos de un formulario.
   * @param {Event} event El evento submit del formulario.
   * @param {string} url La URL a la que se enviarán los datos del formulario.
   * @returns {Object|null} Retorna los datos de respuesta en formato JSON si la solicitud es exitosa, o null en caso de error.
   * @throws {Error} Si la respuesta de la red no es válida o si los datos no son encontrados.
   */
  static async submitForm(event, url) {
    event.preventDefault(); 
    const form = event.target; 
    const formData = new FormData(form);
  
    try {
      const response = await fetch(url, {
        method: 'POST',
        body: formData, 
      });
  
      if (!response.ok) {
        throw new Error('La respuesta de la red no fue correcta ' + response.statusText);
      }
  
      // Se procesa la respuesta como JSON
      const data = await response.json();
      console.log("Respuesta del backend:", data);
      return data;
    } catch (error) {
      console.error('Error al realizar la solicitud POST:', error);
      return null;
    }
  }
  
    
  
}
