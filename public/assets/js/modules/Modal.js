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
