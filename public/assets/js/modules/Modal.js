class Modal {

    static openModal(dom, content, backdropOption, event){

        const options = {
            keyboard: false
        }

        if (backdropOption) {
            options["backdrop"] = backdropOption;
        }

        if (content) {
            const modalBody = dom.querySelector("div.modal-body");
            modalBody.innerHTML = content;
        }

        const modal = new bootstrap.Modal(dom,options);
        modal.show();
    }

}

export {Modal}