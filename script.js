

window.onscroll = function () {
    scrollFunction();
};
function scrollFunction() {
    if (document.body.scrollTop > 150 || document.documentElement.scrollTop > 150) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}
document.getElementById("myBtn").onclick = function scroll() {
    window.scroll({
        left: 0,
        top: 0,
        behavior: 'smooth'
    });
};



