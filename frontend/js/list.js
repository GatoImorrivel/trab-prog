import { get } from "./api.js";

const peopleContainerRef = document.getElementById('people-table-body');

loadPeople();

async function loadPeople() {
    const onEdit = (e) => {
        e.preventDefault();
        const id = e.target.getAttribute('data-id');

        window.location.href = `http://localhost:3000/edit.html?id=${id}`;
    }

    const createRow = ({idPerson, name, email, birth, createdOn}) => {
        const tr = document.createElement('tr');
        const nameE = document.createElement('td');
        const emailE = document.createElement('td');
        const birthE = document.createElement('td');
        const createdOnE = document.createElement('td');
        const editBtnTd = document.createElement('td');
        const editBtn = document.createElement('button');

        nameE.textContent = name;
        emailE.textContent = email;
        birthE.textContent = birth ? birth : 'Não Informado';
        createdOnE.textContent = createdOn;

        editBtnTd.appendChild(editBtn);
        editBtn.setAttribute('class', 'btn btn-primary');
        editBtn.setAttribute('data-id', idPerson);
        editBtn.addEventListener('click', onEdit);
        editBtn.textContent = "Editar";

        tr.appendChild(nameE);
        tr.appendChild(emailE);
        tr.appendChild(birthE);
        tr.appendChild(createdOnE);
        tr.appendChild(editBtnTd);

        peopleContainerRef.appendChild(tr);
    }


    const people = await get('/api.php', 'person', 'getAll');

    for (const person of people) {
        createRow(person);
        createRow(person);
    }
}