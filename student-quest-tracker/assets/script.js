function validateForm() {
    let inputs = document.querySelectorAll("input, textarea, select");

    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].value.trim() === "") {
            alert("Please complete all fields before submitting.");
            return false;
        }
    }

    return true;
}