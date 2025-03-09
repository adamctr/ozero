function confirmDelete(userId) {
    document.getElementById("delete-user-id").value = userId;
    document.getElementById("delete-modal").checked = true;
}

function populateEditForm(button) {
    const dataset = button.dataset;
    document.getElementById("edit-user-id").value = dataset.userId;
    document.getElementById("edit-firstName").value = dataset.firstName;
    document.getElementById("edit-lastName").value = dataset.lastName;
    document.getElementById("edit-nickName").value = dataset.nickName;
    document.getElementById("edit-mail").value = dataset.mail;
    document.getElementById("edit-roleId").value = dataset.roleId;
    document.getElementById("edit-verified").checked = dataset.verified === "true";
}

function populateAddressForm(button) {
    const dataset = button.dataset;
    document.getElementById("edit-address-user-id").value = dataset.userId;
    document.getElementById("edit-street").value = dataset.street;
    document.getElementById("edit-zipCode").value = dataset.zipcode;
    document.getElementById("edit-city").value = dataset.city;
    document.getElementById("edit-country").value = dataset.country;
    document.getElementById("edit-addresse-roleId").value = dataset.roleId;
    document.getElementById("edit-phone").value = dataset.phone;
}
