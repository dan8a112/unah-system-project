import {BarChart} from './chart.js';
import { makeCurrentProcesCard, makeTimeLine } from './Action.js';

const data = {
    currentProces: {
        id: 1,
        name: "II Proceso 2024"
    },
    previousProcessesSummary: {
        applicantsAmount: [5000, 4500, 3000, 5200, 5500, 4830, 4500],
        processes: ["1 2021", "2 2021", "1 2022", "2 2022", "1 2023", "2 2023", "1 2024"]
    },
    previousProcesses: [
    {
        year: "2024",
        processes: [
            {
                id: 4,
                title: "I Proceso 2024"
            }
        ]
    },
    {
        year: "2023",
        processes: [
            {
                id: 3,
                title: "II Proceso 2023"
            },
            {
                id: 2,
                title: "I Proceso 2023"
            }
        ]
    },
    {
        year: "2022",
        processes: [
            {
                id: 1,
                title: "II Proceso 2022"
            },
            {
                id: 6,
                title: "I Proceso 2022"
            }
        ]
    }
    ]
}

if (data.currentProces!= "") {
    makeCurrentProcesCard(data.currentProces.id, data.currentProces.name)
}

const barChart = new BarChart("admissionChart", data.previousProcessesSummary.applicantsAmount, data.previousProcessesSummary.processes);
barChart.draw();

makeTimeLine(data.previousProcesses);


