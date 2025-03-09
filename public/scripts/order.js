arrayId = document.querySelectorAll(".rows");

arrayId.forEach(function (element) {
    const row = element.id;
    element.addEventListener("click", function () {
        window.location.href = `/commandes/${row}`;
    });
});
