window.addEventListener("load", () => {
  const btn = document.querySelector(".coverupsss-single-image>div button");
  const iframe = document.querySelector(".coverupsss-iframee");
  const xIframe = iframe.querySelector("img");
  const btnLink = btn.getAttribute("data-link");
  const iframeEl = iframe.querySelector("iframe");
  console.log(btnLink);
  let counter = 0;
  function toggleIframe() {
    counter < 1 ? iframeEl.setAttribute("src", btnLink) : null;
    counter++;
    iframe.classList.toggle("active");
  }
  btn.addEventListener("click", () => {
    toggleIframe();
  });
  xIframe.addEventListener("click", () => {
    toggleIframe();
  });
});
