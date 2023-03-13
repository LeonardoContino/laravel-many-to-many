const deleteForms = document.querySelectorAll(".delete-form");
deleteForms.forEach((form) => {
    form.addEventListener("submit", (event) => {
        event.preventDefault();
        const name = form.getAttribute("dataEntity") || "elemento";
        const confirm = window.confirm(
            `Sei sicuro di voler eliminare il ${name}?`
        );
        if (confirm) form.submit();
    });
});
