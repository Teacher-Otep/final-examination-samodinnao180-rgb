const API = "../includes/api.php";


function showSection(id){
    document.querySelectorAll('.content, .homecontent')
        .forEach(s => s.style.display = 'none');

    document.getElementById(id).style.display = 'block';
}

function showHome(){
    showSection('home');
}


function addStudent(){
    const data = {
        surname: document.getElementById('surname').value,
        name: document.getElementById('name').value,
        middlename: document.getElementById('middlename').value,
        address: document.getElementById('address').value,
        contact: document.getElementById('contact').value
    };

    fetch(API, {
        method: "POST",
        body: JSON.stringify(data)
    })
    .then(() => {
        alert("Student Added!");
        loadStudents();
    });
}


function loadStudents(){
    showSection('read');

    fetch(API)
    .then(res => res.json())
    .then(data => {
        const tbody = document.querySelector("#table tbody");
        tbody.innerHTML = "";

        data.forEach(s => {
            tbody.innerHTML += `
                <tr>
                    <td>${s.id}</td>
                    <td>${s.surname}, ${s.name} ${s.middlename}</td>
                    <td>
                        <button onclick="edit(${s.id}, '${s.name}', '${s.surname}', '${s.middlename}', '${s.address}', '${s.contact_number}')">Update</button>
                        <button onclick="del(${s.id})">Delete</button>
                    </td>
                </tr>
            `;
        });
    });
}


function del(id){
    if(!confirm("Delete this student?")) return;

    fetch(API + "?id=" + id, { method: "DELETE" })
    .then(() => {
        alert("Deleted!");
        loadStudents();
    });
}


function edit(id, name, surname, middlename, address, contact){
    const newName = prompt("Name:", name);
    const newSurname = prompt("Surname:", surname);
    const newMiddle = prompt("Middle Name:", middlename);
    const newAddress = prompt("Address:", address);
    const newContact = prompt("Contact:", contact);

    fetch(API, {
        method: "PUT",
        body: JSON.stringify({
            id: id,
            name: newName,
            surname: newSurname,
            middlename: newMiddle,
            address: newAddress,
            contact: newContact
        })
    })
    .then(() => {
        alert("Updated!");
        loadStudents();
    });
}