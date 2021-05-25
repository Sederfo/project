solveButton = document.getElementById("solve-button");
containerSolve = document.getElementById("container-solve");
containerRCA = document.getElementById("container-rca");

// solveButton.addEventListener("submit", (e) => {
//   e.preventDefault();
//   containerSolve.style.display = "none";
//   containerRCA.style.display = "flex";
// });

deleteButton = document.getElementById("delete-btn");
deleteModalBg = document.getElementById("delete-modal-bg");
deleteModalClose = document.getElementById("delete-modal-close");
deleteModalCloseButton = document.getElementById(
  "delete-modal-close-no-button"
);

deleteButton.addEventListener("click", () => {
  deleteModalBg.classList.add("bg-active");
});

deleteModalClose.addEventListener("click", () => {
  deleteModalBg.classList.remove("bg-active");
});

deleteModalCloseButton.addEventListener("click", () => {
  deleteModalBg.classList.remove("bg-active");
});
