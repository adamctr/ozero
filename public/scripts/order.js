let count = document.querySelector("#rows").value;

console.log(count);
arrayId = document.querySelectorAll(".rows");
console.log(arrayId);

arrayId.forEach(function (element) {
    const row = element.id;
    element.addEventListener("click", function () {
        window.location.href = `/commandes/${row}`;
    });
});
