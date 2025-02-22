// sortableComponent.js

import Sortable from "sortablejs"; // Assuming you're using Sortable.js

/**
 * @deprecated use componentManager.ts instead
 */
export function initializeSortable(updateKomponenOrder) {
  const tabelKomponen = document.getElementById("tabelKomponen");

  // Initialize Sortable.js on the table
  new Sortable(tabelKomponen, {
    animation: 150,
    onEnd: function () {
      updateKomponenOrder();
    },
  });
}

export function initializeDragAndDrop(updateKomponenOrder) {
  const tabelKomponen = document.getElementById("tabelKomponen");
  const daftarKomponen = document.getElementById("daftarKomponen");

  // Handle drag start on component list
  daftarKomponen.addEventListener("dragstart", function (e) {
    const data = {
      id: e.target.dataset.id,
      name: e.target.dataset.name,
      tunggal: e.target.dataset.tunggal,
    };
    e.dataTransfer.setData("text/plain", JSON.stringify(data));
  });

  // Allow drop on tabelKomponen
  tabelKomponen.addEventListener("dragover", function (e) {
    e.preventDefault();
  });

  // Handle drop event
  tabelKomponen.addEventListener("drop", function (e) {
    e.preventDefault();
    const data = JSON.parse(e.dataTransfer.getData("text/plain"));
    handleDropEvent(data, updateKomponenOrder, e);
  });
}

// Helper function to handle the drop event logic
function handleDropEvent(data, updateKomponenOrder, event) {
  const {
    id: componentId,
    name: componentName,
    tunggal: componentIsSingular,
  } = data;
  const tabelKomponen = document.getElementById("tabelKomponen");

  // Check if the singular component is already in the list
  if (
    componentIsSingular === "true" &&
    document.querySelector(`#tabelKomponen [data-id="${componentId}"]`)
  ) {
    Swal.fire({
      icon: "warning",
      title: "Component Already Added",
      text: "This singular component has already been added.",
      confirmButtonColor: "var(--mdb-primary)",
      confirmButtonText: "Close",
    });
    return;
  }

  // Generate a unique instance ID
  const komponenInstanceId = `inst_${componentId}_${Date.now()}`;

  const componentElement = document.querySelector(
    `#daftarKomponen [data-id="${componentId}"]`
  );
  const componentText = componentElement.innerText;

  // Remove "No components added yet" row if it exists
  const noComponentsRow = document.querySelector(".no-components");
  if (noComponentsRow) {
    noComponentsRow.remove();
  }

  // Create a new row for the dropped component
  const newRow = document.createElement("li");
  newRow.setAttribute("data-id", componentId);
  newRow.setAttribute("data-name", componentName);
  newRow.setAttribute("data-instance-id", komponenInstanceId);
  newRow.classList.add("list-group-item", "p-0", "border-0", "mb-2", "fade-in");
  newRow.innerHTML = `
        <div class="card w-100 d-flex flex-row justify-content-between align-items-center py-3 px-4">
            <div>
                <span class="sortable-handle me-4">☰</span>
                ${componentText}
            </div>
            <div>
                <button type="button" class="btn btn-primary btn-sm btn-floating me-2 edit-komponen">
                    <i class="bi bi-pencil"></i>
                </button>
                <button type="button" class="btn btn-danger btn-sm btn-floating remove-komponen">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    `;

  // Insert the new row at the correct position
  const closestElement = event.target.closest("li");
  if (closestElement) {
    const boundingRect = closestElement.getBoundingClientRect();
    const middleY = boundingRect.top + boundingRect.height / 2;

    if (event.clientY > middleY) {
      tabelKomponen.insertBefore(newRow, closestElement.nextSibling);
    } else {
      tabelKomponen.insertBefore(newRow, closestElement);
    }
  } else {
    tabelKomponen.appendChild(newRow);
  }

  updateKomponenOrder();
}
