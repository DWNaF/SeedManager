document.addEventListener('DOMContentLoaded', () => {

    advanced_search_btn = document.querySelector('#show_filters');

    // modal.close();
    advanced_search_btn.addEventListener('click', () => {
        filters_modal();
        advanced_search_btn.innerText = advanced_search_btn.innerText == 'Recherche avancée +' ? 'Recherche avancée -' : 'Recherche avancée +';
    })

    const closeModal = () => {
        modal.close();
        modal.classList.toggle('hidden');
        advanced_search_btn.innerText = advanced_search_btn.innerText == 'Recherche avancée +' ? 'Recherche avancée -' : 'Recherche avancée +';
    };

    const filters_modal = () => {
        modal = document.querySelector('#modal');
        modal.classList.toggle('hidden');

        if (modal.open) {
            modal.close();
        } else {
            modal.showModal();
        }
        let closeBtn = document.querySelector('#close-modal');
        let validBtn = document.querySelector('#valid-modal');

        if (!closeBtn && !validBtn) {
            closeBtn = document.createElement('button');
            closeBtn.innerText = "X";
            closeBtn.type = "button";
            closeBtn.id = "close-modal";

            closeBtn.addEventListener('click', () => {
                closeModal();
            });

            window.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeModal();
                }
              });

            validBtn = document.createElement('button');
            validBtn.innerText = "Valider";
            validBtn.type = "submit";
            validBtn.form = "advanced_filter_form";
            validBtn.id = "valid-modal";
            validBtn.classList.add('modal_btns');

            modal.appendChild(closeBtn);
            modal.querySelector(".modal_btns_container").appendChild(validBtn);
        }
    }
})