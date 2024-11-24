<?php
    class Validator{

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 08/11/24
         */
        public static function isPhoneNumber(string $number){
            return(preg_match("/(\(\+504\))?\s*[23789]\d{3}-?\d{4}/", $number));
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 08/11/24
         */
        public static function isAccountNumber(string $number){
            return (preg_match("/((19([89]\d))|(2\d\d\d))(1\d\d)(\d{4})/", $number));
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.2.0
         * date: 20/11/24
         */      
        public static function isHondurasIdentityNumber(string $number) {
            $municipalCodes = [
                "0101", "0102", "0103", "0104", "0105", "0106", "0107", "0108", // Atlántida
                "0201", "0202", "0203", "0204", "0205", "0206", "0207", "0208", "0209", "0210", "0211", "0212", "0213", "0214", "0215", // Choluteca
                "0301", "0302", "0303", "0304", "0305", "0306", "0307", "0308", "0309", "0310", // Colón
                "0401", "0402", "0403", "0404", "0405", "0406", "0407", "0408", "0409", "0410", "0411", "0412", "0413", "0414", "0415", "0416", "0417", "0418", "0419", "0420", "0421", // Comayagua
                "0501", "0502", "0503", "0504", "0505", "0506", "0507", "0508", "0509", "0510", "0511", "0512", "0513", "0514", "0515", "0516", "0517", "0518", "0519", "0520", "0521", "0522", "0523", // Copán
                "0601", "0602", "0603", "0604", "0605", "0606", "0607", "0608", "0609", "0610", "0611", "0612", // Cortés
                "0701", "0702", "0703", "0704", "0705", "0706", "0707", "0708", "0709", "0710", "0711", "0712", "0713", // El Paraíso
                "0801", "0802", "0803", "0804", "0805", "0806", "0807", "0808", "0809", "0810", "0811", "0812", "0813", "0814", "0815", // Francisco Morazán
                "0901", "0902", "0903", "0904", "0905", "0906", // Gracias a Dios
                "1001", "1002", "1003", "1004", "1005", "1006", "1007", "1008", "1009", "1010", "1011", "1012", "1013", "1014", "1015", // Intibucá
                "1101", "1102", "1103", // Islas de la Bahía
                "1201", "1202", "1203", "1204", "1205", "1206", "1207", "1208", "1209", "1210", "1211", "1212", "1213", "1214", // La Paz
                "1301", "1302", "1303", "1304", "1305", "1306", "1307", "1308", "1309", "1310", "1311", "1312", "1313", "1314", "1315", "1316", "1317", // Lempira
                "1401", "1402", "1403", "1404", "1405", "1406", "1407", "1408", "1409", "1410", "1411", "1412", // Ocotepeque
                "1501", "1502", "1503", "1504", "1505", "1506", "1507", "1508", "1509", "1510", "1511", "1512", "1513", "1514", "1515", "1516", "1517", "1518", "1519", "1520", "1521", "1522", "1523", "1524", // Olancho
                "1601", "1602", "1603", "1604", "1605", "1606", "1607", "1608", "1609", "1610", "1611", "1612", "1613", "1614", "1615", "1616", "1617", "1618", "1619", "1620", "1621", "1622", "1623", "1624", "1625", // Santa Bárbara
                "1701", "1702", "1703", "1704", "1705", "1706", "1707", "1708", "1709", "1710", "1711", "1712", "1713", // Valle
                "1801", "1802", "1803", "1804", "1805", "1806", "1807", "1808", "1809", "1810", "1811", "1812", "1813", "1814", "1815", "1816", "1817", // Yoro
            ];
            
              // Expresión regular para validar el formato ####-####-#####
            if (preg_match("/^\d{4}-\d{4}-\d{5}$/", $number)) {
                // Extraer los primeros cuatro dígitos
                $prefix = substr($number, 0, 4);

                // Verificar si los primeros cuatro dígitos están en la lista de códigos válidos
                if (in_array($prefix, $municipalCodes)) {
                    return true;
                }
            }

            // Si el formato o los primeros cuatro dígitos no son válidos
            return false;
        }
        
        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 20/11/24
         */
        public static function isEmail(string $email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 20/11/24
         */
        public static function isValidName($name) {
            return (preg_match("/^(?:[A-Za-zÁÉÍÓÚáéíóúÑñ]{2,25})?$/", $name));
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 23/11/24
         */
        public static function isValidSecondName($name) {
            return (preg_match("/^(?:[A-Za-zÁÉÍÓÚáéíóúÑñ]{2,25})(?:\s[A-Za-zÁÉÍÓÚáéíóúÑñ]{2,25})*$/", $name));
        }  
        
    }  
?>