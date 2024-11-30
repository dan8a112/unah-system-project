/**
 * Crea una sección con una tabla dinámica que respeta los estilos dados y agrega paginación si es necesario.
 * @author afcastillof@unah.hn
 * @version 0.3.0
 * @date 29/11/24
 * @param {string} sectionTitle - Título de la sección.
 * @param {Array<string>} headers - Lista de encabezados para las columnas de la tabla.
 * @param {Array<Array<any>>} rows - Matriz de datos para las filas iniciales de la tabla.
 * @param {string} tableId - ID opcional para el cuerpo de la tabla.
 * @param {number} limit - Número máximo de filas por página.
 * @param {number} totalRecords - Número total de registros disponibles.
 * @param {string} apiUrl - URL del servicio que entrega los nuevos datos, con soporte para paginación.
 * @param {boolean} isFetchPagination - Indica si la paginación se basa en datos locales o en un servicio externo.
 */
export function createTable(sectionTitle, headers, rows, tableId, limit, totalRecords, apiUrl, isFetchPagination) {
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
    renderRows(currentRows, tbody);

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
        // Botones de número de página
        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement("li");
            pageButton.className = `page-item ${i === 1 ? 'active' : ''}`;
            pageButton.innerHTML = `<a class="page-link" href="#">${i}</a>`;

            pageButton.querySelector("a").addEventListener("click", (event) => {
                event.preventDefault(); // Evita que la página se desplace hacia arriba
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
        prevButton.querySelector("a").addEventListener("click", (event) => {
            event.preventDefault(); // Evita que la página se desplace hacia arriba
            const currentPage = parseInt(document.querySelector(".pagination .page-item.active a").textContent, 10);
            if (currentPage > 1) {
                const newPage = currentPage - 1;
                paginationList.children[newPage].querySelector("a").click();
            }
        });

        nextButton.querySelector("a").addEventListener("click", (event) => {
            event.preventDefault(); // Evita que la página se desplace hacia arriba
            const currentPage = parseInt(document.querySelector(".pagination .page-item.active a").textContent, 10);
            if (currentPage < totalPages) {
                const newPage = currentPage + 1;
                paginationList.children[newPage].querySelector("a").click();
            }
        });
    }

    return section;
}

/**
 * Actualiza la página actual de la tabla consumiendo datos de un servicio externo o paginando datos locales.
 * @param {string} apiUrl - URL del servicio que entrega los nuevos datos.
 * @param {HTMLElement} tbody - Elemento tbody de la tabla.
 * @param {number} limit - Número máximo de filas por página.
 * @param {number} page - Página a mostrar.
 * @param {boolean} isFetchPagination - Indica si la paginación se basa en datos locales o en un servicio externo.
 * @param {Array<Array<any>>} rows - Matriz de datos locales (si isFetchPagination es true).
 */
async function updateTablePage(apiUrl, tbody, limit, page, isFetchPagination, rows) {
    tbody.innerHTML = ""; // Limpia las filas existentes

    if (isFetchPagination) {
        // Paginación basada en datos locales
        const start = (page - 1) * limit;
        const currentRows = rows.slice(start, start + limit);
        renderRows(currentRows, tbody);
    } else {
        // Paginación basada en un servicio externo
        const offset = (page - 1) * limit;
        const url = `${apiUrl}&offset=${offset}`;

        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`Error al obtener datos: ${response.statusText}`);
            }

            const data = await response.json();
            const fetchedRows = data.data || []; // Suponiendo que el servicio devuelve un objeto con una propiedad "data"

            renderRows(fetchedRows, tbody);
        } catch (error) {
            console.error("Error al actualizar la tabla:", error);
        }
    }
}

/**
 * Renderiza las filas en un tbody dado.
 * @param {Array<Array<any>>} rows - Matriz de datos para las filas.
 * @param {HTMLElement} tbody - Elemento tbody donde se agregarán las filas.
 */
function renderRows(rows, tbody) {
    rows.forEach(rowData => {
        const row = document.createElement("tr");

        rowData.forEach(cellData => {
            const td = document.createElement("td");
            td.textContent = cellData;
            row.appendChild(td);
        });

        tbody.appendChild(row);
    });
}