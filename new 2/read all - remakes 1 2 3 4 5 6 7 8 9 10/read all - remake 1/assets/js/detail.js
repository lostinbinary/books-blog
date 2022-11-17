const iframeBtn = document.querySelector(
  ".special-readdd-descriptions span[data-link]",
);
const overlay = document.querySelector(".special-readdd-descriptions");
const iframe = document.querySelector(".special-readdd-iframe iframe");
iframeBtn.addEventListener("click", function (e) {
  overlay.style.display = "none";
  let curr = e.currentTarget.getAttribute("data-link");
  iframe.src = curr;
});

const moreLess = document.querySelector(".special-readdd-less-more");
const textEl = document.querySelector(".special-readdd-staff-text");
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
