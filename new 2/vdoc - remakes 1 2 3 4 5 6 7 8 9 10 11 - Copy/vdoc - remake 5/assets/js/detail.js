const iframeBtn = document.querySelector(
  ".einvaterss-descriptions span[data-link]",
);
const iframe = document.querySelector(".einvaterss-iframe iframe");
iframeBtn.addEventListener("click", function (e) {
  let curr = e.currentTarget.getAttribute("data-link");
  iframe.src = curr;
});

const moreLess = document.querySelector(".einvaterss-less-more");
const textEl = document.querySelector(".einvaterss-staff-text");
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
