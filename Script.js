// ---------------------------
// MOBILE MENU TOGGLE
// ---------------------------
const menuBtn = document.getElementById("menuBtn");
const navMenu = document.getElementById("navMenu");

menuBtn.addEventListener("click", () => {
    navMenu.classList.toggle("active");
});

// ---------------------------
// SMOOTH SCROLL BUTTON
// ---------------------------
document.getElementById("scrollBtn")?.addEventListener("click", () => {
    document.querySelector("#materials").scrollIntoView({ behavior: "smooth" });
});

// ---------------------------
// FADE-IN ANIMATION ON SCROLL
// ---------------------------
const sections = document.querySelectorAll(".fade");

function fadeInOnScroll() {
    sections.forEach(sec => {
        const rect = sec.getBoundingClientRect();
        if (rect.top < window.innerHeight - 100) {
            sec.classList.add("visible");
        }
    });
}
window.addEventListener("scroll", fadeInOnScroll);
fadeInOnScroll();

// ---------------------------
// CONTACT FORM (FRONT-END ONLY)
// ---------------------------
document.getElementById("contactForm")?.addEventListener("submit", (e) => {
    e.preventDefault();

    alert("Message Sent Successfully!");

    document.getElementById("name").value = "";
    document.getElementById("email").value = "";
    document.getElementById("msg").value = "";
});

// ---------------------------
// PDF VIEWER SYSTEM
// ---------------------------
// Opens PDF in view-pdf.html?file=yourfile.pdf
function openPDF(filePath) {
    window.location.href = "view-pdf.php?file=" + encodeURIComponent(filePath);
}

// Attach openPDF function globally
window.openPDF = openPDF;


// ---------------------------
// MCQ TEST SYSTEM
// ---------------------------
const quizData = [
    {
        question: "What is the full form of CPU?",
        a: "Central Processing Unit",
        b: "Control Processing Unit",
        c: "Central Power Unit",
        d: "Control Power Unit",
        correct: "a"
    },
    {
        question: "HTML is used for?",
        a: "Styling",
        b: "Backend",
        c: "Structuring a Webpage",
        d: "Database",
        correct: "c"
    }
];

let index = 0;
let score = 0;

function loadQuestion() {
    if (!document.getElementById("questionBox")) return;

    const data = quizData[index];
    document.getElementById("questionBox").innerHTML = data.question;
    document.getElementById("optionA").nextElementSibling.innerHTML = data.a;
    document.getElementById("optionB").nextElementSibling.innerHTML = data.b;
    document.getElementById("optionC").nextElementSibling.innerHTML = data.c;
    document.getElementById("optionD").nextElementSibling.innerHTML = data.d;
}

function submitQuiz() {
    const options = document.getElementsByName("option");

    let selected = "";
    options.forEach((opt) => {
        if (opt.checked) selected = opt.value;
    });

    if (selected === quizData[index].correct) {
        score++;
    }

    index++;

    if (index < quizData.length) {
        options.forEach(opt => opt.checked = false);
        loadQuestion();
    } else {
        document.querySelector(".quiz-container").innerHTML = `
            <h2>Your Score: ${score}/${quizData.length}</h2>
            <button onclick="location.reload()">Restart</button>
        `;
    }
}

window.submitQuiz = submitQuiz;

// Load quiz automatically
loadQuestion();


// ---------------------------
// DASHBOARD MENU HIGHLIGHT
// ---------------------------
const menuItems = document.querySelectorAll(".sidebar a");

menuItems.forEach(item => {
    item.addEventListener("click", () => {
        menuItems.forEach(i => i.classList.remove("active"));
        item.classList.add("active");
    });
});
