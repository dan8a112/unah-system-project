class Modal {
    static modalInstance = null; 

    static openModal(dom, content, title, backdropOption) {
        const options = {
            keyboard: false
        };

        if (backdropOption) {
            options["backdrop"] = backdropOption;
        }

        if (content) {
            const modalBody = dom.querySelector("div.modal-body");
            modalBody.innerHTML = content;
        }

        if (title) {
            const modalText = dom.querySelector("h5.modal-title");
            modalText.innerHTML = title;
        }

        Modal.modalInstance = new bootstrap.Modal(dom, options);
        
        // Asegurar eliminación del backdrop
        Modal.cleanBackdrop();
        
        Modal.modalInstance.show();
    }

    static closeModal() {
        if (Modal.modalInstance) {
            Modal.modalInstance.hide();

            // Asegurar eliminación del backdrop
            Modal.cleanBackdrop();

        } else {
            console.warn("No se encontró una instancia activa del modal para cerrar.");
        }
    }

    // Método para limpiar cualquier backdrop residual
    static cleanBackdrop() {
        const backdrops = document.querySelectorAll(".modal-backdrop");
        backdrops.forEach((backdrop) => {
            backdrop.parentNode.removeChild(backdrop);
        });

        // Restablecer overflow del body (por si acaso quedó alterado)
        document.body.classList.remove("modal-open");
        document.body.style.overflow = "";
        document.body.style.paddingRight = "";
    }

}

export { Modal };
