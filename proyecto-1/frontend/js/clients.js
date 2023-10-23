const URL = 'http://127.0.0.1/proyecto_1/routes/clients.php';

// Elementos HTML
const htmlForm = document.getElementById('form');
const tableBody = document.getElementById("tbody");
const modalCreate = document.getElementById("modalCreate");
// Inputs
const documentTypeInput = document.getElementById('documentType');
const documentInput = document.getElementById('document');
const nameInput = document.getElementById('name');
const lineInput = document.getElementById('line');
const cityInput = document.getElementById('city');
const emailInput = document.getElementById('email');

let updateLine = false;

function createTd (inner) {
    const td = document.createElement('td');
    td.innerHTML = inner;
    return td;
}

function createRow(data) {
   const tr = document.createElement('tr');
   tr.className = 'text-center align-middle';
    
   for (let key in data) { tr.appendChild(createTd(data[key])); }

   const lastTd =
    `<td>\
        <button class="btn btn-success" onclick="getClient(${data['line']})">\
            <span class="mdi mdi-pencil"></span>\
        </button>\
    </td>`;
   
   tr.appendChild(createTd(lastTd));
   return tr;
}

function drawRows (data) {
    for (let i = 0; i < data.length; i++) {
        const row = createRow(data[i]);
        tableBody.appendChild(row);
    }
}

function removeBefore () {
    while (tableBody.firstChild) { tableBody.removeChild(tableBody.lastChild); }
}

async function getData () {
    try {
        removeBefore();
        const { data } = await axios.get(URL);
        drawRows(data);
    } catch (err) {
        console.log(err);
    }
}

function getParams () {
    const params = new URLSearchParams();
    params.append('documentType', documentTypeInput.value);
    params.append('document', documentInput.value);
    params.append('name', nameInput.value);
    params.append('line', lineInput.value);
    params.append('city', cityInput.value);
    params.append('email', emailInput.value);
    return params;
}

function showModal () {
    const modalBootstrap = bootstrap.Modal.getOrCreateInstance(modalCreate);
    modalBootstrap.show();
}

function hideModal () {
    const modalBootstrap = bootstrap.Modal.getOrCreateInstance(modalCreate);
    modalBootstrap.hide();
    updateLine = false;

    documentTypeInput.value = '';
    documentInput.value = '';
    nameInput.value = '';
    lineInput.value = '';
    cityInput.value = '';
    emailInput.value = '';
}

async function saveClient (event) {
    try {
        event.preventDefault();
        if (!htmlForm.checkValidity()) {
            htmlForm.classList.add('was-validated');
            return;
        } 

        if (updateLine) {
            await axios.patch(`${URL}?line=${updateLine}`, getParams());
        } else {
            await axios.post(URL, getParams());
        }
        getData();
        hideModal();
        showToast('Guardado exitosamente', 'success', 
            document.getElementById('toast'));
    } catch (err) {
        console.log(err);
        showToast(err, 'danger', 
            document.getElementById('toast'));
    }
}

async function getClient (line) {
    try {
        const { data } = await axios.get(`${URL}?line=${line}`);

        documentTypeInput.value = data['documentType'];
        documentInput.value = data['document'];
        nameInput.value = data['name'];
        lineInput.value = data['line'];
        cityInput.value = data['city'];
        emailInput.value = data['email'];
    
        updateLine = line;
        showModal();
    } catch (err) {
        showToast(err, 'danger', 
            document.getElementById('toast'));
    }
}


htmlForm.addEventListener("submit", saveClient);