class Modal {

    static openModal(dom, event){

        const options = {
            keyboard: false
        }

        const modal = new bootstrap.Modal(dom,options);
        modal.show();
    }

}

export {Modal}