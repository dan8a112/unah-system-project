class Modal {
    static modalInstance = null; 

    static openModal(dom, content, backdropOption) {
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

        Modal.modalInstance = new bootstrap.Modal(dom, options);
        Modal.modalInstance.show();
    }

    static closeModal() {
        if (Modal.modalInstance) {
            Modal.modalInstance.hide();
            Modal.modalInstance = null;
        } else {
            console.warn("No se encontró una instancia activa del modal para cerrar.");
        }
    }
}

export { Modal };
