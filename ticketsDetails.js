solveButton = document.getElementById("solve-button");
containerSolve = document.getElementById("container-solve");
containerRCA = document.getElementById("container-rca");

solveButton.addEventListener("click", () => {
  containerSolve.style.display = "none";
  containerRCA.style.display = "flex";
});