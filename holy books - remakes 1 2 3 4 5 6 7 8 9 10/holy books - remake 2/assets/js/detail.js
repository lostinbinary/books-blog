const iframeBtn = document.querySelector(".role-modelll-iframe-btn");
const iframe = document.querySelector(".role-modelll-iframe iframe");
const iframeCircle = document.querySelector(".role-modelll-circles");
const link = iframeBtn.getAttribute("data-link");
iframeBtn.addEventListener("click", function () {
  iframeCircle.style.display = "block";
  iframe.src = link;
  iframeBtn.style.display = "none";
  setTimeout(function () {
    iframeCircle.style.display = "none";
  }, 10000);
});
