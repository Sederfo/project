// variables for add ticket modal
var modalBtn = document.getElementById("addTicketButton");
var modalBg = document.querySelector(".modal-bg");
var modalClose = document.querySelector(".modal-close");
var modalDone = document.querySelector(".doneBtn");

//variables for add account modal
var addAccount = document.getElementById("add-account");
var accModalBg = document.querySelector(".acc-modal-bg");
var accModalClose = document.querySelector(".acc-modal-close");
var accModalDone = document.querySelector(".accDoneBtn");

addAccount.addEventListener("click", () => {
  accModalBg.classList.add("acc-bg-active");
});

accModalClose.addEventListener("click", () => {
  accModalBg.classList.remove("acc-bg-active");
});

accModalDone.addEventListener("submit", (e) => {
  e.preventDefault();
  accModalBg.remove("bg-active");
});

modalBtn.addEventListener("click", () => {
  modalBg.classList.add("bg-active");
});

modalClose.addEventListener("click", () => {
  modalBg.classList.remove("bg-active");
});

modalDone.addEventListener("submit", (e) => {
  e.preventDefault();
  var subject = document.getElementById("sbj").value;
  var description = document.getElementById("dsc").value;
  var priority = document.getElementById("priority").value;

  modalBg.classList.remove("bg-active");
  window.location.reload();
});

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
