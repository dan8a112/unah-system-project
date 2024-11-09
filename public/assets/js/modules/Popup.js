/**
 * Esta clase abre el componente pop dependiendo de la respuesta de backend
 * 
 * author: afcastillof@unah.hn
 * version: 0.1.1
 * date: 8/11/24
 */
export class Popup {
  
    /**
     * Abre el componente pop
     * @param {string} url 
     * @returns {Object|null} 
     * @throws {Error} 
     */
    static open(popup, result) {
        console.log(result)
        if(result.status){
            popup.style.display = "block";
            window.scrollTo({ top: 0, behavior: "smooth" });
        }
        
    }
   
      
    
  }
  