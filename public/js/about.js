let current = document.querySelector('#current');
let imgs = document.querySelectorAll('.imgs img');
let opacity = 0.5;

// Set first img opacity
imgs[0].style.opacity = opacity;

imgs.forEach(img => img.addEventListener('click',imgClick));

function imgClick(e) {
    // Reset opacity
    imgs.forEach(img => (img.style.opacity = 1))
    current.src = e.target.src;

    // Add fade in 
    current.classList.add('fade-in');

    // Remove fade-in after 0.5 seconds
    setTimeout(() => current.classList.remove('fade-in'),500);
    e.target.style.opacity = opacity;
    if (screen.width >=801 ){
        window.scrollTo(0,window.innerHeight/1.1);
    } 
}
