import { Action } from "../process_detail_active/Action.js"

const data = {
    dates:{
        start: "19 de Mayo, 2024",
        end: "30 de Mayo, 2024"
    },
    processState:{
        id: 2,
        name: "Inscripciones"
    },
    amountInscriptions: 201,
    lastestInscriptions: [
        {
            id:1,
            name:"Maria Jose Valle",
            career:"Ingenieria Industrial",
            inscriptionDate: "12/10/2024"
        },
        {
            id:2,
            name:"Jose Alberto Valle",
            career:"Ingenieria Civil",
            inscriptionDate: "14/10/2024"
        }
    ],
    csvStatus: true
}

Action.renderActiveProcess(data)

