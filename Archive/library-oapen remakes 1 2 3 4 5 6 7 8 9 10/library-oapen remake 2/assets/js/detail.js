const iframeBtn = document.querySelector(".dealinggg-iframe-btn");
const iframe = document.querySelector(".dealinggg-iframe iframe");
const iframeCircle = document.querySelector(".dealinggg-circles");
const link = iframeBtn.getAttribute("data-link");
iframeBtn.addEventListener("click", function () {
  iframeCircle.style.display = "block";
  iframe.src = link;
  iframeBtn.style.display = "none";
  setTimeout(function () {
    iframeCircle.style.display = "none";
  }, 10000);
});
