document.addEventListener('DOMContentLoaded', () => {
    delete_seeds_btns = document.querySelectorAll('.delete_seed_btn');
    delete_seeds_btns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (confirm('Are you sure you want to delete this seed?')) {
                btn.preventDefault();
            }
        })
    });
})