const URL = 'http://127.0.0.1/proyecto_1/routes/payments.php';

// Elementos HTML
const htmlForm = document.getElementById('form');
const tableBody = document.getElementById("tbody");
const modalCreate = document.getElementById("modalCreate");
// Inputs
const contractCodeInput = document.getElementById('contractCode');
const amountInput = document.getElementById('amount');
const createdAtInput = document.getElementById('createdAt');

let updateId = '';
let updateContractCode = '';

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
        <button class="btn btn-success" onclick="getPayment(${data['id']},\
        ${data['contractCode']})">\
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
    params.append('contractCode', contractCodeInput.value);
    params.append('amount', amountInput.value);
    params.append('createdAt', createdAtInput.value);
    return params;
}

function showModal () {
    const modalBootstrap = bootstrap.Modal.getOrCreateInstance(modalCreate);
    modalBootstrap.show();
}

function hideModal () {
    const modalBootstrap = bootstrap.Modal.getOrCreateInstance(modalCreate);
    modalBootstrap.hide();
    updateId = '';
    updateContractCode = '';

    contractCodeInput.value = '';
    amountInput.value = '';
    createdAtInput.value = '';
}

async function savePayment (event) {
    try {
        event.preventDefault();
        if (!htmlForm.checkValidity()) {
            htmlForm.classList.add('was-validated');
            return;
        } 

        if (updateId) {
            console.log('updateId', updateId);
            console.log('updateContractcODE', updateContractCode);
            await axios.patch(
                `${URL}?id=${updateId}&contractCode=${updateContractCode}`,
                getParams());
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

async function getPayment (id, contractCode) {
    try {
        const { data } = await axios.get(`${URL}?id=${id}`);

        contractCodeInput.value = data['contractCode'];
        amountInput.value = data['amount'];
        const dateData = data['createdAt'].split(' ')[0];

        console.log('dateData*****', dateData);
        createdAtInput.value = dateData;
    
        updateId = id;
        updateContractCode = contractCode;
        showModal();
    } catch (err) {
        showToast(err, 'danger', 
            document.getElementById('toast'));
    }
}


htmlForm.addEventListener("submit", savePayment);