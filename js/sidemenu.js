function toggleMenu() {
    const menu = document.getElementById("sideMenu");
    const overlay = document.getElementById("overlay");

    menu.classList.toggle("active");
    overlay.classList.toggle("show-overlay");
}

function closeMenu(){
    document.getElementById("sideMenu").classList.remove("active");
    document.getElementById("overlay").classList.remove("show-overlay");
}

function toggleAdmin(){
    document.getElementById("subMenu").classList.toggle("show-admin");
}

document.addEventListener("click", function(event){
    const menu = document.getElementById("sideMenu");
    const menuIcon = document.querySelector(".menu-icon");
    const overlay = document.getElementById("overlay");

    if(!menu.contains(event.target) && !menuIcon.contains(event.target)){
        menu.classList.remove("active");
        overlay.classList.remove("show-overlay");
    }
});