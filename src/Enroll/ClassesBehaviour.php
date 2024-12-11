<?php
    class ClassesBehaviour{

        public function validateRequirements($approvedClasses, $requisites) {

            // Iterar sobre cada requisito
            foreach ($requisites as $requisite) {
                // Verificar si el requisito no está en la lista de clases aprobadas
                if ($requisite!=null && !in_array($requisite, $approvedClasses)) {
                    return false; // Si falta algún requisito, retornar false
                }
            }

            // Si todos los requisitos están presentes, retornar true
            return true;
        }

    }