document.getElementById("attachmentForm").addEventListener("submit", function(event) {
  event.preventDefault();

  const formData = new FormData(this);

  fetch("upload.php", {
    method: "POST",
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    console.log(data);
    // Handle the server response as needed
  })
  .catch(error => {
    console.error("Error:", error);
  });
});
