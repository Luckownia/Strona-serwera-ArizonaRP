//LANDING-PAGE

//Change light-mode
const inputCheckbox = document.querySelector(".switch-mode-checkbox");
const circleImage = document.querySelector(".circle-image");
const logoPalm = document.querySelector(".logo img");

//Hovering cursor on elements
const logo = document.querySelector(".logo");
const navLabel = document.querySelector("label");
const cursor = document.querySelector(".mouse");

const animateCursor = () => {
  cursor.classList.add("cursor-animate");
};

const removeAnimateCursor = () => {
  cursor.classList.remove("cursor-animate");
};

logo.addEventListener("mouseenter", animateCursor);
logo.addEventListener("mouseleave", removeAnimateCursor);
navLabel.addEventListener("mouseenter", animateCursor);
navLabel.addEventListener("mouseleave", removeAnimateCursor);

// Cursor
window.addEventListener("mousemove", (e) => {
  let x = e.clientX;
  let y = e.clientY;
  cursor.style.top = y + "px";
  cursor.style.left = x + "px";
});

// MOBILNY BURGER
const hamburger = document.querySelector(".hamburger");
const navigation = document.querySelector(".navigation");

hamburger.addEventListener("click", () => {
  navigation.classList.toggle("wrap");
  hamburger.classList.toggle("vidmo");
});

// Focus state of nav-links
const navLinks = document.querySelectorAll(".nav-link");

navLinks.forEach((link) => {
  link.addEventListener("click", () => {
    navLinks.forEach((link1) => {
      if (link1.classList.contains("active")) {
        link1.classList.remove("active");
      }
    });
    link.classList.add("active");
  });

  link.addEventListener("mouseenter", animateCursor);
  link.addEventListener("mouseleave", removeAnimateCursor);
});

// LANDING PAGE -2
const photo = document.querySelector(".logo img");
const sectionFrist = document.querySelector(".feature-1");
const sectionSec = document.querySelector(".feature-2");
const sectionThr = document.querySelector(".feature-3");
const sectionFor = document.querySelector(".feature-4");
const sekcjaFor = document.querySelector("#section-4");
let theme = "dark";
const currentTheme = localStorage.getItem("theme");

inputCheckbox.addEventListener("click", function () {
  document.body.classList.toggle("darkmode");
  if (circleImage.src.endsWith("sun.png")) {
    circleImage.src = "../assets/moon.png";
    photo.src = "../assets/blackpalm.png";
    theme = "dark";
  } else if (circleImage.src.endsWith("moon.png")) {
    circleImage.src = "../assets/sun.png";
    photo.src = "../assets/palm-tree-48.png";
    theme = "light";
  }
  localStorage.setItem("theme", theme);
});

function themechange() {
  if (currentTheme == "dark") {
    document.body.classList.add("darkmode");
    circleImage.src = "../assets/moon.png";
    photo.src = "../assets/blackpalm.png";
    theme = "dark";
  } else if (currentTheme == "light") {
    document.body.classList.remove("darkmode");
    circleImage.src = "../assets/sun.png";
    photo.src = "../assets/palm-tree-48.png";
    theme = "light";
  }
}
themechange();

window.addEventListener("scroll", function () {
  if (window.scrollY > sectionFrist.offsetTop) {
    sectionFrist.classList.add("left-side");
  }
  if (window.scrollY > sectionSec.offsetTop + 1000) {
    sectionSec.classList.add("right-side");
  }
  if (window.scrollY > sekcjaFor.offsetTop - 500) {
    sectionFor.classList.add("right-side");
  }
  if (window.scrollY > sectionThr.offsetTop + 1900) {
    sectionThr.classList.add("left-side");
  }
});
