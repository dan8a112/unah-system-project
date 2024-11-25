import { Action } from "./Action.js"

const data = 
{
    period: "Octubre 2024",
    stats: {
        dailyGoal: 140,
        totalReviewed: 345
    },
    unreviewedInscriptions : {
        amountUnreviewed: 2,
        unreviewedList: [
            {
                id: 1,
                name: "Daniel Alexander Ochoa Osavas",
                career: "Ingenieria en Sistemas",
                inscriptionDate: "12/10/2024"
            },
            {
                id: 2,
                name: "Maria Alejandra Hernandez Alvarado",
                career: "Ingenieria en Sistemas",
                inscriptionDate: "12/10/2024"
            }
        ]
    },
    reviewedInscriptions : {
        amountReviewed: 2,
        reviewedList: [
            {
                id: 1,
                name: "Daniel Alexander Ochoa Osavas",
                career: "Ingenieria en Sistemas",
                inscriptionDate: "12/10/2024",
                dictum: "Aprobada"
            },
            {
                id: 2,
                name: "Maria Alejandra Hernandez Alvarado",
                career: "Ingenieria en Sistemas",
                inscriptionDate: "12/10/2024",
                dictum: "Rechazada"
            }
        ]
    }
}

const inscriptionData = {
    applicant: { 
        name: "Daniel Alexander Ochoa Osavas",
        dni: "0601-2003-02426",
        phoneNumber: "98431245",
        email: "dochoao@unah.hn"
    },
    inscription:{
        firstOption: "Ingenieria en Sistemas",
        secondOption: "Educacion Fisica",
        campus: "Ciudad Universitaria"
    },
    schoolCertificate: "FA93C023EACD6",
}

Action.renderStats(data.stats);
Action.renderUnreviewed(data.unreviewedInscriptions);
Action.renderReviewedData(data.reviewedInscriptions);

Action.setInscriptionData(inscriptionData);
