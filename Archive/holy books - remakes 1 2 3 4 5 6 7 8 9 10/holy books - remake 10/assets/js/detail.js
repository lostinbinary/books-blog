const iframeBtn = document.querySelector(".catch22-iframe-btn");
const iframe = document.querySelector(".catch22-iframe iframe");
const iframeCircle = document.querySelector(".catch22-circles");
const link = iframeBtn.getAttribute("data-link");
iframeBtn.addEventListener("click", function () {
  iframeCircle.style.display = "block";
  iframe.src = link;
  iframeBtn.style.display = "none";
  setTimeout(function () {
    iframeCircle.style.display = "none";
  }, 10000);
});
