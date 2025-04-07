function toggleModal() {
  const modal = document.getElementById("loginModal");
  modal.style.display = modal.style.display === "block" ? "none" : "block";
}

// Close the modal if the user clicks outside of the modal content
window.onclick = function (event) {
  const modal = document.getElementById("loginModal");
  if (event.target === modal) {
    modal.style.display = "none";
  }
};
