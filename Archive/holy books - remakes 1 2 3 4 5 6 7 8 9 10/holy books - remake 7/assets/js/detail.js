const iframeBtn = document.querySelector(".throughhh-iframe-btn");
const iframe = document.querySelector(".throughhh-iframe iframe");
const iframeCircle = document.querySelector(".throughhh-circles");
const link = iframeBtn.getAttribute("data-link");
iframeBtn.addEventListener("click", function () {
  iframeCircle.style.display = "block";
  iframe.src = link;
  iframeBtn.style.display = "none";
  setTimeout(function () {
    iframeCircle.style.display = "none";
  }, 10000);
});
