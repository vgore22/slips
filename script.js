// Toggle Mobile Menu
const menuBtn = document.getElementById("menuBtn");
const navMenu = document.getElementById("navMenu");

menuBtn.onclick = () => {
    navMenu.style.display =
        navMenu.style.display === "flex" ? "none" : "flex";
};

// Smooth scroll button
document.getElementById("scrollBtn").onclick = () => {
    document.getElementById("materials").scrollIntoView({ behavior: "smooth" });
};

// Scroll fade animation
const faders = document.querySelectorAll(".fade");

function showElements() {
    faders.forEach(item => {
        const box = item.getBoundingClientRect().top;
        if (box < window.innerHeight - 100) {
            item.classList.add("show");
        }
    });
}

window.addEventListener("scroll", showElements);
showElements();

// Contact form alert
document.getElementById("contactForm").addEventListener("submit", function(e) {
    e.preventDefault();
    alert("Thank you! Your message has been sent.");
});
