// variables for add ticket modal
var modalBtn = document.getElementById("add-ticket-btn");
var modalBg = document.getElementById("ticket-modal-bg");
var modalClose = document.getElementById("ticket-modal-close");
var modalDone = document.getElementById("ticket-done-btn");

modalBtn.addEventListener("click", () => {
  modalBg.classList.add("bg-active");
});

modalClose.addEventListener("click", () => {
  modalBg.classList.remove("bg-active");
});

modalDone.addEventListener("submit", (e) => {
  e.preventDefault();
  modalBg.classList.remove("bg-active");
  window.location.reload();
});

//color rows
document.addEventListener("DOMContentLoaded", () => {
  const rows = document.querySelectorAll("tr[data-href]");
  rows.forEach((row) => {
    row.addEventListener("click", () => {
      var ticketId = row.children[0].textContent;
      console.log(ticketId);
      window.location.href = row.dataset.href + "?id=" + ticketId;
    });
    switch (row.children[5].textContent) {
      case "pending":
        row.children[5].style.color = "rgb(204, 163, 0)";
        break;
      case "in progress":
        row.children[5].style.color = "green";
        break;
      case "solved":
        row.children[5].style.color = "red";
        break;
      default:
        row.children[5].style.color = "black";
    }
  });
});
