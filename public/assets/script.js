let connectionModal = document.getElementById('connectionModal');

function openConnectionModal(){
    connectionModal.className = 'modal is-active';
}
function closeConnectionModal(){
    connectionModal.className = 'modal';
}

function toggleBurgerMenu(){
    document.getElementById('navbar-burger-id').classList.toggle('is-active');
    document.getElementById('navbar-menu-id').classList.toggle('is-active');
}