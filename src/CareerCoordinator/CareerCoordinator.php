<?php

class CoordinatorDAO {
    private $mysqli;

    public function __construct(string $server, string $user, string $pass, string $dbName) {
        $this->mysqli = new mysqli($server, $user, $pass, $dbName);
    }

        /**
         * author: wamorales@unah.hn
         * version: 0.2.0
         * date: 10/12/24
         * 
         * Funcion que obtiene la carga academica del ultimo periodo respecto a un coordinador
         */
    public function getAcademicLoad(int $coordinatorId, int $offset = 0) {
        // Obtener la lista de periodos
        $queryPeriods = "SELECT AcademicEvent.id id, CONCAT(AcademicProcess.description, ' ' ,YEAR(AcademicEvent.startDate)) 
                name
                FROM AcademicEvent
                INNER JOIN AcademicProcess ON AcademicEvent.process=AcademicProcess.id
                WHERE AcademicEvent.process=8 OR AcademicEvent.process=9 OR AcademicEvent.process=10
                ORDER BY AcademicEvent.startDate ASC;";

        $periodsResult = $this->mysqli->execute_query($queryPeriods);
        $periods = [];
        while ($row = $periodsResult->fetch_assoc()) {
            $periods[] = $row;
        }

        // Obtener el periodo actual (ultimo sin parametro)----descartar el academicEventID
        $queryCurrentPeriod = "SELECT AcademicEvent.id id,
                                CONCAT(AcademicProcess.description, ' ' ,YEAR(AcademicEvent.startDate))  name
                                FROM AcademicEvent
                                INNER JOIN AcademicProcess ON AcademicEvent.process=AcademicProcess.id
                                WHERE AcademicEvent.id=(SELECT MAX(AcademicEvent.id) FROM AcademicEvent 
                                WHERE process=8 OR process=9 OR process=10);";

        $currentPeriodResult = $this->mysqli->execute_query($queryCurrentPeriod);
        $currentPeriod = $currentPeriodResult->fetch_assoc();

        // Obtener las secciones del periodo actual
        $querySections = "SELECT Section.id code, Subject.description class, Section.section, 
                CONCAT(Employee.names, ' ', Employee.lastNames) professor, 
                Section.enrolled , Section.maximumCapacity places, Building.description building, 
                Classroom.description classroom
                FROM Section
                INNER JOIN Subject ON Subject.id=Section.subject
                INNER JOIN Professor ON Section.professor=Professor.id
                INNER JOIN Employee ON Professor.id=Employee.id
                INNER JOIN Classroom ON Section.classroom=Classroom.id
                INNER JOIN Building ON Classroom.building=Building.id
                INNER JOIN AcademicEvent ON Section.academicEvent=AcademicEvent.id
                INNER JOIN Department ON Professor.department=Department.id
                WHERE Department.id=(SELECT department FROM Professor WHERE id=?) and AcademicEvent.id=(SELECT MAX(AcademicEvent.id) FROM AcademicEvent 
                                WHERE process=8 OR process=9 OR process=10)
                LIMIT 10 OFFSET ?;";

        $sectionListResult = $this->mysqli->execute_query($querySections, [$coordinatorId, $offset]);
        $sectionList = [];
        while ($row = $sectionListResult->fetch_assoc()) {
            $sectionList[] = $row;
        }

        // Contar el total de secciones
        $queryAmountSections = "SELECT COUNT(*) AS amount
        FROM Section
        INNER JOIN Subject ON Section.subject = Subject.id
        INNER JOIN Department ON Department.id = Subject.department
        INNER JOIN AcademicEvent ON Section.academicEvent = AcademicEvent.id
        WHERE Department.id = (SELECT department FROM Professor WHERE id = ?)
        AND AcademicEvent.id = (SELECT MAX(AcademicEvent.id) FROM AcademicEvent 
                                WHERE process=8 OR process=9 OR process=10);";

        $amountSectionsResult = $this->mysqli->execute_query($queryAmountSections, [$coordinatorId]);
        $amountSections = $amountSectionsResult->fetch_assoc()['amount'];

        // Obtener la carrera del coordinador
        $queryCareer = "SELECT Department.description career FROM Professor
        INNER JOIN Department ON Professor.department=Department.id
        WHERE Professor.id=?;";

        $careerResult = $this->mysqli->execute_query($queryCareer, [$coordinatorId]);
        $career = $careerResult->fetch_assoc()['career'];

        return [
            "periods" => $periods,
            "currentPeriod" => $currentPeriod,
            "sections" => [
                "amountSections" => $amountSections,
                "sectionList" => $sectionList
            ],
            "career" => $career
        ];
    }

    public function closeConnection() {
        $this->mysqli->close();
    }
}

?>
