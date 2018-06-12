let connectionModal = document.getElementById('connectionModal');
let ingredients = document.getElementById('ingredients');
let rowCounter = 0;
if(ingredients !== null){rowCounter = ingredients.childElementCount;}

function openConnectionModal(){
    connectionModal.className = 'modal is-active';
}
function closeConnectionModal(){
    connectionModal.className = 'modal';
}

function toggleBurgerMenu(){
    document.getElementById('navbar-burger-id').classList.toggle('is-active');
    document.getElementById('navbar-menu-id').classList.toggle('is-active');
}


function addIngredientNode(){
    let table = document.getElementById('ingredients');
    let row = table.insertRow(table.childElementCount);

    let nameCell = row.insertCell(0);
    let qteCell = row.insertCell(1);
    let unitCell = row.insertCell(2);
    let actionCell = row.insertCell(3);

    nameCell.innerHTML = "<input type='text' class='input' placeholder='Salade, tomate, oignon, ...' name='ingredients["+rowCounter+"][0]'>";
    qteCell.innerHTML = "<input type='number' min='0' value='0' class='input' name='ingredients["+rowCounter+"][1]'>";
    unitCell.innerHTML = "<input type='text' class='input' placeholder='kg, ...' name='ingredients["+rowCounter+"][2]'>";
    actionCell.innerHTML = "<div class='button' onclick='deleteIngredientNode(this)'><span class='icon is-left'><i class='fas fa-minus'></i></span></div>";
    rowCounter++;
}
function deleteIngredientNode(element){
    let index = element.parentElement.parentElement.rowIndex;
    document.getElementById('ingredients').deleteRow(index-1);
}