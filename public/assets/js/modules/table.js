/**
 * Crea una sección con una tabla dinámica que respeta los estilos dados.
 * @author afcastillof@unah.hn
 * @version 0.1.1
 * @date 19/11/24
 * @param {string} sectionTitle - Título de la sección.
 * @param {Array<string>} headers - Lista de encabezados para las columnas de la tabla.
 * @param {Array<Array<any>>} rows - Matriz de datos para las filas de la tabla.
 * @param {string} tableId - ID opcional para el cuerpo de la tabla.
 */
export function createTable(sectionTitle, headers, rows, tableId) {
    // Crear la sección
    const section = document.createElement("section");
    section.className = "row";
    section.style.marginTop = "1.5rem"

    // Crear el contenedor de la tarjeta
    const cardContainer = document.createElement("div");
    cardContainer.className = "card-container";

    // Agregar el título de la sección
    const title = document.createElement("p");
    title.className = "fs-2";
    title.textContent = sectionTitle;

    // Crear la tabla
    const table = document.createElement("table");
    table.className = "table";

    // Crear el encabezado de la tabla
    const thead = document.createElement("thead");
    const headerRow = document.createElement("tr");

    headers.forEach(headerText => {
        const th = document.createElement("th");
        th.scope = "col";
        th.textContent = headerText;
        headerRow.appendChild(th);
    });

    thead.appendChild(headerRow);
    table.appendChild(thead);

    // Crear el cuerpo de la tabla
    const tbody = document.createElement("tbody");
    tbody.id = tableId;

    rows.forEach(rowData => {
        const row = document.createElement("tr");

        rowData.forEach(cellData => {
            const td = document.createElement("td");
            td.textContent = cellData;
            row.appendChild(td);
        });

        tbody.appendChild(row);
    });

    table.appendChild(tbody);

    // Construir la estructura completa
    cardContainer.appendChild(title);
    cardContainer.appendChild(table);
    section.appendChild(cardContainer);

    return section;
}
