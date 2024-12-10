<?php

Class StudentDAO {
    private $mysqli;

    public function __construct(string $server, string $user, string $pass, string $dbName) {
        $this->mysqli = new mysqli($server, $user, $pass, $dbName);
    }

    public function getStudentAcademicHistory(string $studentId, int $offset = 0, int $limit = 10) {
        // Consulta principal para obtener información del estudiante
        $queryStudentInfo = 'SELECT 
                CONCAT(s.name, " ", s.lastName) AS studentName,
                d.description AS studentCareer,
                s.account AS studentAccount,
                s.description AS studentDescription,
                s.globalAverage AS studentGlobalIndex,
                s.periodAverage AS studentPeriodIndex,
                r.description AS studentCenter,
                s.photo1 AS imgStudent
            FROM Student s 
            INNER JOIN DegreeProgram d ON s.degreeProgram=d.id
            INNER JOIN RegionalCenter r ON s.regionalCenter=r.id
            WHERE s.account = ?;';
        
        $resultStudentInfo = $this->mysqli->execute_query($queryStudentInfo, [$studentId]);
        
        if (!$resultStudentInfo) {
            return [
                "status" => false,
                "message" => "Error al obtener la información del estudiante."
            ];
        }

        $studentInfo = $resultStudentInfo->fetch_assoc();
     

        // Consulta para obtener el historial académico (clases) con paginación
        $queryClasses = 'SELECT Section.id, 
            Subject.id code, 
            Subject.description class,
            Subject.uv,
            Section.section section,
            YEAR(AcademicEvent.startDate) year,
            (AcademicEvent.process-7) period,
            StudentSection.grade calification,
            Observation.observation observation
            FROM StudentSection
            INNER JOIN Section ON Section.id=StudentSection.section
            INNER JOIN Subject ON Section.subject=Subject.id
            INNER JOIN AcademicEvent ON AcademicEvent.id=Section.academicEvent
            INNER JOIN Observation ON Observation.id=StudentSection.observation
            WHERE StudentSection.studentAccount=?
            ORDER BY year ASC, period ASC
            LIMIT ? OFFSET ?;';
        
        $resultClasses = $this->mysqli->execute_query($queryClasses, [$studentId, $limit, $offset]);

        $classesList = [];
        if ($resultClasses) {
            while ($row = $resultClasses->fetch_assoc()) {
                $classesList[] = $row;
            }
        }

        // Consulta para contar el total de clases cursadas
        $queryTotalClasses = 'SELECT COUNT(*) AS amountClasses
            FROM StudentSection
            WHERE studentAccount = ?;';
        
        $resultTotalClasses = $this->mysqli->execute_query($queryTotalClasses, [$studentId]);
        
        $amountClasses = 0;
        if ($resultTotalClasses) {
            $amountClasses = $resultTotalClasses->fetch_assoc()['amountClasses'] ?? 0;  // Uso de coalescencia nula
        }

        // Retorno de los datos con control de valores nulos
        return [
            "status" => true,
            "message" => "Petición realizada con éxito.",
            "data" => [
                "studentInfo" => [
                    "studentName" => $studentInfo['studentName'] ?? 'No disponible',  // Uso de coalescencia nula
                    "studentCareer" => $studentInfo['studentCareer'] ?? 'No disponible',  // Uso de coalescencia nula
                    "studentAccount" => $studentInfo['studentAccount'] ?? 'No disponible',  // Uso de coalescencia nula
                    "studentDescription" => $studentInfo['studentDescription'] ?? 'No disponible',  // Uso de coalescencia nula
                    "studentGlobalIndex" => $studentInfo['studentGlobalIndex'] ?? 'No disponible',  // Uso de coalescencia nula
                    "studentPeriodIndex" => $studentInfo['studentPeriodIndex'] ?? 'No disponible',  // Uso de coalescencia nula
                    "studentCenter" => $studentInfo['studentCenter'] ?? 'No disponible',  // Uso de coalescencia nula
                    "imgStudent" => $studentInfo['imgStudent'] ?? 'No disponible'  // Uso de coalescencia nula
                ],
                "classes" => [
                    "amountClasses" => $amountClasses,
                    "classList" => $classesList
                ]
            ]
        ];
    }

    public function closeConnection() {
        $this->mysqli->close();
    }
}
