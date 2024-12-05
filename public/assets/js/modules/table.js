/**
 * Crea una sección con una tabla dinámica que respeta los estilos dados y agrega paginación si es necesario.
 * @author afcastillof@unah.hn
 * @version 0.3.1
 * @date 02/12/24
 * @param {string} sectionTitle - Título de la sección.
 * @param {Array<string>} headers - Lista de encabezados para las columnas de la tabla.
 * @param {Array<Array<any>>} rows - Matriz de datos para las filas iniciales de la tabla.
 * @param {string} tableId - ID opcional para el cuerpo de la tabla.
 * @param {number} limit - Número máximo de filas por página.
 * @param {number} totalRecords - Número total de registros disponibles.
 * @param {string} apiUrl - URL del servicio que entrega los nuevos datos, con soporte para paginación.
 * @param {boolean} isFetchPagination - Indica si la paginación se basa en datos locales o en un servicio externo.
 * @param {boolean} [renderAsHtml=false] - Indica si las celdas deben renderizarse como HTML (true) o como texto (false).
 */
export function createTable(sectionTitle, headers, rows, tableId, limit, totalRecords, apiUrl, isFetchPagination, renderAsHtml = true, tranformData) {
    // Crear la sección
    const section = document.createElement("section");
    section.className = "row";
    section.style.marginBottom = "8px";

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

    // Mostrar registros iniciales
    const currentRows = rows.slice(0, limit);
    renderRows(currentRows, tbody, renderAsHtml);

    table.appendChild(tbody);

    // Construir la estructura completa
    cardContainer.appendChild(title);
    cardContainer.appendChild(table);
    section.appendChild(cardContainer);

    // Crear la paginación si es necesario
    if (totalRecords > limit) {
        const totalPages = Math.ceil(totalRecords / limit);
        const pagination = document.createElement("nav");
        pagination.setAttribute("aria-label", "Page navigation");
        pagination.style.marginTop = "3px";

        const paginationList = document.createElement("ul");
        paginationList.className = "pagination";

        // Botón "Previous"
        const prevButton = document.createElement("li");
        prevButton.className = "page-item disabled";
        prevButton.innerHTML = `<a class="page-link" href="#">Previous</a>`;
        paginationList.appendChild(prevButton);

        // Botones de número de página
        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement("li");
            pageButton.className = `page-item ${i === 1 ? 'active' : ''}`;
            pageButton.innerHTML = `<a class="page-link" href="#">${i}</a>`;

            pageButton.querySelector("a").addEventListener("click", (event) => {
                event.preventDefault();
                updateTablePage(apiUrl, tbody, limit, i, isFetchPagination, rows, renderAsHtml, tranformData);
                document.querySelectorAll(".pagination .page-item").forEach(item => item.classList.remove("active"));
                pageButton.classList.add("active");
                prevButton.classList.toggle("disabled", i === 1);
                nextButton.classList.toggle("disabled", i === totalPages);
            });

            paginationList.appendChild(pageButton);
        }

        // Botón "Next"
        const nextButton = document.createElement("li");
        nextButton.className = `page-item ${totalPages > 1 ? '' : 'disabled'}`;
        nextButton.innerHTML = `<a class="page-link" href="#">Next</a>`;
        paginationList.appendChild(nextButton);

        pagination.appendChild(paginationList);
        section.appendChild(pagination);

        // Asignar eventos de los botones "Previous" y "Next" después de que se hayan creado.
        prevButton.querySelector("a").addEventListener("click", (event) => {
            event.preventDefault();
            const currentPage = parseInt(document.querySelector(".pagination .page-item.active a").textContent, 10);
            if (currentPage > 1) {
                const newPage = currentPage - 1;
                pagination.querySelector(`.page-item:nth-child(${newPage + 1}) a`).click();
            }
        });

        nextButton.querySelector("a").addEventListener("click", (event) => {
            event.preventDefault();
            const currentPage = parseInt(document.querySelector(".pagination .page-item.active a").textContent, 10);
            if (currentPage < totalPages) {
                const newPage = currentPage + 1;
                pagination.querySelector(`.page-item:nth-child(${newPage + 1}) a`).click();
            }
        });

    }

    return section;
}

/**
 * Renderiza las filas en un tbody dado.
 * @author afcastillof@unah.hn
 * @version 0.5.1
 * @date 05/12/24
 * @param {Array<Array<any>> || Array<Object>} rows - Matriz de datos para las filas. O un arreglo de objetos.
 * @param {HTMLElement} tbody - Elemento tbody donde se agregarán las filas.
 * @param {boolean} renderAsHtml - Indica si las celdas deben renderizarse como HTML (true) o como texto (false).
 */
function renderRows(rows, tbody, renderAsHtml) {
    rows.forEach(rowData => {
        const row = document.createElement("tr");
        if (typeof rowData === "object" && rowData !== null) {
            Object.keys(rowData).forEach(key => {
                const td = document.createElement("td");
                if (renderAsHtml) {
                    td.innerHTML = rowData[key];
                } else {
                    td.textContent = rowData[key];
                }
                row.appendChild(td);
            });
        } else if (rowData !== null && Array.isArray(rowData)) {
            rowData.forEach(cellData => {
                const td = document.createElement("td");
                if (renderAsHtml) {
                    td.innerHTML = cellData;
                } else {
                    td.textContent = cellData;
                }
                row.appendChild(td);
            });
        } else {
            console.error("El Formato de rows no es el correcto");
        }
        tbody.appendChild(row);
    });
}

/**
 * Funcion para actualizar los datos en la tabla a partir de la pajinacion
 * @author afcastillof@unah.hn
 * @version 0.5.1
 * @date 05/12/24
 * @param {string} apiUrl 
 * @param {div} tbody 
 * @param {int} limit 
 * @param {int} page 
 * @param {boolean} isFetchPagination 
 * @param {Array} rows 
 * @param {boolean} renderAsHtml 
 * @param {function name(params) {}} tranformData 
 */
async function updateTablePage(
    apiUrl, tbody, limit, page, isFetchPagination, rows, renderAsHtml, tranformData) {
    tbody.innerHTML = ""; 

    if (isFetchPagination) {
        const start = (page - 1) * limit;
        const currentRows = rows.slice(start, start + limit);
        const transformedRows = tranformData ? tranformData(currentRows) : currentRows;

        renderRows(transformedRows, tbody, renderAsHtml);
    } else {
        const offset = (page - 1) * limit;
        const url = `${apiUrl}offset=${offset}`;

        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`Error al obtener datos: ${response.statusText}`);
            }

            const data = await response.json();
            const transformedData = tranformData ? tranformData(data.data) : data.data;

            renderRows(transformedData, tbody, renderAsHtml);
        } catch (error) {
            console.error(error);
        }
    }
}



export function createPagination(section, tbody, limit, totalRecords, apiUrl, isFetchPagination, rows){

    // Crear la paginación si es necesario
    if (totalRecords > limit) {
        const totalPages = Math.ceil(totalRecords / limit);
        const pagination = document.createElement("nav");
        pagination.setAttribute("aria-label", "Page navigation");
        pagination.style.marginTop = "3px";

        const paginationList = document.createElement("ul");
        paginationList.className = "pagination";

        // Botón "Previous"
        const prevButton = document.createElement("li");
        prevButton.className = "page-item disabled";
        prevButton.innerHTML = `<a class="page-link" href="#">Previous</a>`;
        paginationList.appendChild(prevButton);

        // Botones de número de página
        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement("li");
            pageButton.className = `page-item ${i === 1 ? 'active' : ''}`;
            pageButton.innerHTML = `<a class="page-link" href="#">${i}</a>`;

            pageButton.addEventListener("click", () => {
                updateTablePage(apiUrl, tbody, limit, i, isFetchPagination, rows);
                document.querySelectorAll(".pagination .page-item").forEach(item => item.classList.remove("active"));
                pageButton.classList.add("active");
                prevButton.classList.toggle("disabled", i === 1);
                nextButton.classList.toggle("disabled", i === totalPages);
            });

            paginationList.appendChild(pageButton);
        }

        // Botón "Next"
        const nextButton = document.createElement("li");
        nextButton.className = `page-item ${totalPages > 1 ? '' : 'disabled'}`;
        nextButton.innerHTML = `<a class="page-link" href="#">Next</a>`;
        paginationList.appendChild(nextButton);

        pagination.appendChild(paginationList);
        section.appendChild(pagination);

        // Eventos para botones "Previous" y "Next"
        prevButton.addEventListener("click", () => {
            const currentPage = parseInt(document.querySelector(".pagination .page-item.active a").textContent, 10);
            if (currentPage > 1) {
                const newPage = currentPage - 1;
                paginationList.children[newPage].querySelector("a").click();
            }
        });

        nextButton.addEventListener("click", () => {
            const currentPage = parseInt(document.querySelector(".pagination .page-item.active a").textContent, 10);
            if (currentPage < totalPages) {
                const newPage = currentPage + 1;
                paginationList.children[newPage].querySelector("a").click();
            }
        });
    }
}
