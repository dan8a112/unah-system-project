<?php
class EnrollDAO{

    public function __construct(string $server, string $user, string $pass, string $dbName) {
        $this->mysqli = new mysqli($server, $user, $pass, $dbName);
    }

    /**
     * author: dochoao@unah.hn
     * version: 0.1.0
     * date: 11/12/24
     * 
     * Funcion para obtener los departamentos de matricula a partir del numero de cuenta de un estudiante
     */
    public function getDepartments($account): array{

        $departments = [];
        $query = 'SELECT e.id, e.description
                FROM `Student` a
                INNER JOIN `DegreeProgram` b ON a.`degreeProgram` = b.id 
                INNER JOIN `SubjectDegree` c ON b.id = c.`degreeProgram`
                INNER JOIN `Subject` d ON c.subject = d.id
                INNER JOIN `Department` e ON d.department = e.id
                WHERE `account`=?
                GROUP BY e.id,e.description;';

        $result = $this->mysqli->execute_query($query, [$account]);

        foreach ($result as $row) {
            $departments[] = [
                "id" => $row["id"],
                "name" => $row['description']
            ];
        }

        return $departments;
    }

    /**
     * author: dochoao@unah.hn
     * version: 0.1.0
     * date: 11/12/24
     * 
     * Funcion para obtener los departamentos de matricula a partir del numero de cuenta de un estudiante
     */
    public function getClasses($account, $departmentId): array{

        $classes = [];
        $query = 'SELECT DISTINCT d.id, d.description
            FROM `Student` a
            INNER JOIN `DegreeProgram` b ON a.`degreeProgram` = b.id 
            INNER JOIN `SubjectDegree` c ON b.id = c.`degreeProgram`
            INNER JOIN `Subject` d ON c.subject = d.id
            INNER JOIN `Department` e ON d.department = e.id
            WHERE `account`=? and e.id=?;';

        $result = $this->mysqli->execute_query($query, [$account, $departmentId]);

        foreach ($result as $row) {
            $classes[] = [
                "id" => $row["id"],
                "name" => $row['description']
            ];
        }

        return $classes;
    }

    /**
     * author: dochoao@unah.hn
     * version: 0.1.0
     * date: 11/12/24
     * 
     * Funcion para obtener las secciones a partir de una clase y el periodo academico actual
     */
    public function getSections($classId): array{

        $sections = [];
        $query = "SELECT a.id, CONCAT(a.section,' : ', c.names, ' ', c.`lastNames`) as section
                from `Section` a
                INNER JOIN `Professor` b ON a.professor = b.id
                INNER JOIN `Employee` c ON b.id = c.id
                WHERE a.`academicEvent`= (SELECT actualAcademicPeriod()) AND a.subject=?;";

        $result = $this->mysqli->execute_query($query, [$classId]);

        foreach ($result as $row) {
            $sections[] = [
                "id" => $row["id"],
                "name" => $row['section']
            ];
        }

        return $sections;
    }

    /**
     * author: dochoao@unah.hn
     * version: 0.1.0
     * date: 11/12/24
     * 
     * Funcion para obtener las secciones a partir de una clase y el periodo academico actual
     */
    public function getApprovedClasses($account): array{

        $classes = [];
        //Se obtienen las clases del estudiante que esten aprobadas y no en espera
        $query = "SELECT c.id
                    from `StudentSection` a
                    INNER JOIN `Section` b on a.section = b.id
                    INNER JOIN `Subject` c on b.subject = c.id
                    WHERE a.`studentAccount`=? and a.observation=1 and a.waiting=0;";

        $result = $this->mysqli->execute_query($query, [$account]);

        foreach ($result as $row) {
            $classes[] = $row["id"];
        }

        return $classes;
    }

    /**
     * author: dochoao@unah.hn
     * version: 0.1.0
     * date: 11/12/24
     * 
     * Funcion para obtener las secciones a partir de una clase y el periodo academico actual
     */
    public function getRequisites($classId): array{

        $requirements = [];
        //Se obtienen las clases del estudiante que esten aprobadas y no en espera
        $query = "SELECT requirement
                FROM `SubjectDegree`
                WHERE subject=?";

        $result = $this->mysqli->execute_query($query, [$classId]);

        foreach ($result as $row) {
            $requirements[] = $row["requirement"];
        }

        return $requirements;
    }

    // Método para cerrar la conexión
    public function closeConnection()
    {
        $this->mysqli->close();
    }
}