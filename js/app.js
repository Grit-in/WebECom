function showForm(formId) {
  document.querySelectorAll(".form-box").forEach(form =>
    form.classList.remove("active")
  );
  document.getElementById(formId).classList.add("active");
}

function toggleDropdown() {
  document.getElementById("dropdownMenu").classList.toggle("show");
}

window.onclick = function(event) {
  if (!event.target.closest('.dropdown')) {
    document.querySelectorAll(".dropdown-menu").forEach(menu => {
      menu.classList.remove("show");
    });
  }
};