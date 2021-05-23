const init = () => {
  document.getElementById("block-list-button").addEventListener("click", () => {
    document.getElementById("block-list-wrapper").classList.toggle("hide")
  })
}

init()
