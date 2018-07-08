// if (window.matchMedia("(max-width: 775px)").matches) {

// }

let menuBtn = document.getElementById('menu-btn');
// function openMenu(){
//     menuBtn.style.height = 'auto';

// }
// menuBtn.addEventListener('click',openMenu());
let colNavContainer = document.getElementById('col-nav-container');
// function toggleMenu(){
//     if (colNavContainer.style.height === 'auto') {
//         colNavContainer.style.height = '0';
//     } else {
//         colNavContainer.style.height = 'auto';
//     }
// }

menuBtn.addEventListener("click",function(){
    if (colNavContainer.style.height === '150px') {
        colNavContainer.style.height = '0';
    } else {
        colNavContainer.style.height = '150px';
    }
});
