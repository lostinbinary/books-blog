const iframeBtn = document.querySelector(
  ".couldddd-descriptions span[data-link]",
);
const overlay = document.querySelector(".couldddd-descriptions");
const iframe = document.querySelector(".couldddd-iframe iframe");
iframeBtn.addEventListener("click", function (e) {
  overlay.style.display = "none";
  let curr = e.currentTarget.getAttribute("data-link");
  iframe.src = curr;
});

const moreLess = document.querySelector(".couldddd-less-more");
const textEl = document.querySelector(".couldddd-staff-text");
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
