/**
 * Esta clase abre el componente pop dependiendo de la respuesta de backend
 * 
 * author: afcastillof@unah.hn
 * version: 0.1.0
 * date: 9/11/24
 */
export class Popup {
  
    /**
     * Abre el componente pop
     * @param {div} contenedor de pop
     */
    static open(popup) {
            popup.style.display = "block";
            window.scrollTo({ top: 0, behavior: "smooth" });
        
    }

    //Cierra el componente y redirige a la pantalla de landingPage

    static close1(popup) {
        popup.style.display = "none";
        window.location.href = '/';
    }

    //Cierra el componente
    static close(popup) {
        popup.style.display = "none";
        console.log('hola')
    }

    //Cierra el componente y redirige a la pantalla informativa
    static close2(popup) {
        popup.style.display = "none";
        window.location.href = '/assets/views/informative/InformativeAdmission.php';
    }
        
  }
  