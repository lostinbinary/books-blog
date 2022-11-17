const iframeBtn = document.querySelector(
  ".educateddd-descriptions span[data-link]",
);
const overlay = document.querySelector(".educateddd-descriptions");
const iframe = document.querySelector(".educateddd-iframe iframe");
iframeBtn.addEventListener("click", function (e) {
  overlay.style.display = "none";
  let curr = e.currentTarget.getAttribute("data-link");
  iframe.src = curr;
});

const moreLess = document.querySelector(".educateddd-less-more");
const textEl = document.querySelector(".educateddd-staff-text");
let more = moreLess.getAttribute("data-more");
let less = moreLess.getAttribute("data-less");
moreLess.textContent = more;
moreLess.addEventListener("click", () => {
  if (textEl.classList.contains("active")) {
    moreLess.textContent = more;
    textEl.classList.remove("active");
  } else {
    moreLess.textContent = less;
    textEl.classList.add("active");
  }
});
