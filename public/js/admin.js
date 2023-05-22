document.addEventListener("DOMContentLoaded", () => {
    let imgInput = document.getElementById("image");
    let imgPreview = document.getElementById("new_image_preview");

    if (imgInput && imgPreview) {
        imgPreview.style.display = "none";
        imgInput.addEventListener("change", (event) => {
            const [file] = imgInput.files;
            if (file) {
                imgPreview.src = URL.createObjectURL(file);
                imgPreview.style.display = "block";
            }
        });
    }
})