const box = document.querySelector('.burger_box');

box.addEventListener('click', e => {
    e.target.classList.toggle('active');
});
