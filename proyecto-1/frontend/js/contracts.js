const URL = 'http://127.0.0.1/proyecto_1/routes/contracts.php';

// Elementos HTML
const htmlForm = document.getElementById('form');
const tableBody = document.getElementById("tbody");
const modalCreate = document.getElementById("modalCreate");
// Inputs
const codeInput = document.getElementById('code');
const clientLineInput = document.getElementById('clientLine');
const priceInput = document.getElementById('price');
const activatedAtInput = document.getElementById('activatedAt');
const statusInput = document.getElementById('status');

let updateCode = false;

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
        <button class="btn btn-success" onclick="getContract(${data['code']})">\
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
    params.append('code', codeInput.value);
    params.append('clientLine', clientLineInput.value);
    params.append('price', priceInput.value);
    params.append('activatedAt', activatedAtInput.value);
    params.append('status', statusInput.value);
    return params;
}

function showModal () {
    const modalBootstrap = bootstrap.Modal.getOrCreateInstance(modalCreate);
    modalBootstrap.show();
}

function hideModal () {
    const modalBootstrap = bootstrap.Modal.getOrCreateInstance(modalCreate);
    modalBootstrap.hide();
    updateCode = false;

    codeInput.value = '';
    clientLineInput.value = '';
    priceInput.value = '';
    activatedAtInput.value = '';
    statusInput.value = 'Active';
}

async function saveContract (event) {
    try {
        event.preventDefault();
        if (!htmlForm.checkValidity()) {
            htmlForm.classList.add('was-validated');
            return;
        } 

        if (updateCode) {
            await axios.patch(`${URL}?code=${updateCode}`, getParams());
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

async function getContract (code) {
    try {
        const { data } = await axios.get(`${URL}?code=${code}`);

        codeInput.value = data['code'];
        clientLineInput.value = data['clientLine'];
        priceInput.value = data['price'];
        activatedAtInput.value = data['activatedAt'];
        statusInput.value = data['status'];
    
        updateCode = code;
        showModal();
    } catch (err) {
        showToast(err, 'danger', 
            document.getElementById('toast'));
    }
}


htmlForm.addEventListener("submit", saveContract);