
export const makeCurrentProcesCard = (id, name) => {
    const cardContainer = document.createElement('div');
    cardContainer.className = 'currentProcesCard';
    const capIcon = document.createElement('img');
    const title = document.createElement('h2');
    title.innerHTML = name;
    const subtitle = document.createElement('h5');
    cardContainer.appendChild(capIcon, title, subtitle);
}