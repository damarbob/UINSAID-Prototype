// componentManager.ts (former sortableComponent.ts)

import Sortable from "sortablejs";
import Swal from "sweetalert2";
import EditComponentMetaModal from "./editComponentMetaModal"; //
import ComponentData from "./interface/componentData";
import ComponentMetaData from "./interface/componentMetaData";
import UiEditComponenMetaModal from "./interface/uiEditComponentMetaModal";
import UiComponentManagement from "./interface/uiComponentManagement";
import { getComponentDataById } from "./use-case/componentManagementUseCase";
import i18next from "i18next";
import { ComponentOrderData } from "./interface/componentOrderData";

export default class ComponentManager {
  // Constants
  private COMPONENT_ELEMENT_DATA_ATTR_ID = "id";
  private COMPONENT_ELEMENT_DATA_ATTR_NAME = "name";
  private COMPONENT_ELEMENT_DATA_ATTR_INSTANCE_ID = "instanceId";
  private COMPONENT_ELEMENT_DATA_ATTR_SINGULAR = "singular";

  // Dependencies
  private editModal: EditComponentMetaModal;

  // Parameters
  private pageId: number;
  private availableComponents: Array<ComponentData>;
  private uiComponentManagement: UiComponentManagement;

  // Selector
  private noComponentSelector: string = ".no-components"; // Internal reference
  private editComponentSelector: string = ".edit-komponen"; // Internal reference
  private deleteComponentSelector: string = ".remove-komponen"; // Internal reference

  /**
   * Constructs a new instance of the ComponentManager class.
   *
   * @param componentsTable - The HTMLUListElement representing the list of components added to the table.
   * @param availableComponentsList - The HTMLUListElement representing the list of available components.
   * @param componentsOrderInput - The HTMLInputElement where the order of the components is saved.
   */
  constructor(
    pageId: number,
    availableComponents: Array<ComponentData>,
    uiComponentManagement: UiComponentManagement
  ) {
    this.pageId = pageId;
    this.availableComponents = availableComponents;
    this.uiComponentManagement = uiComponentManagement;

    this.editModal = new EditComponentMetaModal();

    this.initializeSortable();
    this.initializeDragAndDrop();
    this.initializeEventHandlers();

    uiComponentManagement.loader.classList.add("d-none"); // Hide the loader

    // console.log("SortableComponent: constructor(): Invoked");
  }

  // Initialize Sortable.js on the table
  /**
   * Initializes the Sortable.js library on the components table to enable drag-and-drop sorting.
   *
   * This function sets up the Sortable.js instance on the components table, allowing
   * the user to reorder components by dragging and dropping them. The animation duration
   * for the sorting is set to 150 milliseconds. After sorting is completed, the component
   * order is updated.
   *
   * @returns void
   */
  private initializeSortable(): void {
    new Sortable(this.uiComponentManagement.componentsTable, {
      animation: 150,
      onEnd: () => {
        this.updateComponentOrder();
      },
    });
  }

  /**
   * Initializes drag-and-drop functionality for the component lists.
   *
   * This function sets up event listeners to handle drag-and-drop interactions
   * between the available components list and the components table. It allows
   * components to be dragged from the available list and dropped into the table.
   *
   * @returns void
   */
  private initializeDragAndDrop(): void {
    // Handle drag start on component list
    this.uiComponentManagement.availableComponentsList.addEventListener(
      "dragstart",
      (e: DragEvent) => {
        const target = e.target as HTMLElement;
        if (!target) return;

        const data: ComponentData = {
          id: target.dataset[this.COMPONENT_ELEMENT_DATA_ATTR_ID] || "",
          name: target.dataset[this.COMPONENT_ELEMENT_DATA_ATTR_NAME] || "",
          content: null,
          meta: null,
          singular:
            target.dataset[this.COMPONENT_ELEMENT_DATA_ATTR_SINGULAR] || "",
        };
        e.dataTransfer?.setData("text/plain", JSON.stringify(data));
      }
    );

    // Allow drop on tabelKomponen
    this.uiComponentManagement.componentsTable.addEventListener(
      "dragover",
      function (e: DragEvent) {
        e.preventDefault();
      }
    );

    // Handle drop event
    this.uiComponentManagement.componentsTable.addEventListener(
      "drop",
      (e: DragEvent) => {
        e.preventDefault();
        const dataString = e.dataTransfer?.getData("text/plain");
        if (!dataString) return;

        const data: ComponentData = JSON.parse(dataString);
        // console.log(dataString);
        this.handleDropEvent(data, e);
      }
    );
  }

  /**
   * Handles the drop event for a component, adding it to the components table.
   *
   * @param data - The data of the component being dropped, including its id, name, and singularity status.
   * @param event - The drag event containing information about the drop location.
   * @returns void
   */
  private handleDropEvent(data: ComponentData, event: DragEvent): void {
    const {
      id: componentId,
      name: componentName,
      singular: componentIsSingular,
    } = data;

    // console.log("singular: " + (componentIsSingular == "1"));

    // Check if the component is singular and already added
    if (
      componentIsSingular === "1" &&
      // Checks if similar component is already exist in the page
      this.uiComponentManagement.componentsTable.getElementByDataAttr(
        this.COMPONENT_ELEMENT_DATA_ATTR_ID,
        componentId
      )
    ) {
      Swal.fire({
        icon: "warning",
        title: i18next.t("error"),
        text: i18next.t("component_already_added"),
        confirmButtonColor: "var(--mdb-primary)",
        confirmButtonText: i18next.t("close"),
      });
      return;
    }

    // Generate a unique instance ID
    const komponenInstanceId = `inst_${componentId}_${Date.now()}`;

    // const componentElement =
    //   this.uiComponentManagement.availableComponentsList.querySelector(
    //     `[data-id="${componentId}"]`
    //   ) as HTMLElement;
    const componentElement =
      this.uiComponentManagement.availableComponentsList.getElementByDataAttr(
        this.COMPONENT_ELEMENT_DATA_ATTR_ID,
        componentId
      );
    const componentText = (componentElement as HTMLElement).innerText || "";

    // Remove "No components added yet" row if it exists
    const noComponentsRow = document.querySelector(this.noComponentSelector);
    noComponentsRow?.remove();

    // Create new list item
    const newRow = document.createElement("li");
    newRow.dataset[this.COMPONENT_ELEMENT_DATA_ATTR_ID] = componentId;
    newRow.dataset[this.COMPONENT_ELEMENT_DATA_ATTR_NAME] = componentName;
    newRow.dataset[this.COMPONENT_ELEMENT_DATA_ATTR_INSTANCE_ID] =
      komponenInstanceId;
    // console.log(newRow.dataset);
    newRow.classList.add(
      "list-group-item",
      "p-0",
      "border-0",
      "mb-2",
      "fade-in"
    );
    newRow.innerHTML = `
        <div class="card w-100 d-flex flex-row justify-content-between align-items-center py-3 px-4">
            <div>
                <span class="sortable-handle me-4">☰</span>
                ${componentText}
            </div>
            <div>
                <button type="button" class="btn btn-primary btn-sm btn-floating me-2 ${this.editComponentSelector.slice(
                  1
                )}">
                    <i class="bi bi-pencil"></i>
                </button>
                <button type="button" class="btn btn-danger btn-sm btn-floating ${this.deleteComponentSelector.slice(
                  1
                )}">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    `;

    // Insert the new row at the drop position
    const closestElement = (event.target as HTMLElement).closest("li");
    if (closestElement) {
      const boundingRect = closestElement.getBoundingClientRect();
      const middleY = boundingRect.top + boundingRect.height / 2;

      if (event.clientY > middleY) {
        this.uiComponentManagement.componentsTable.insertBefore(
          newRow,
          closestElement.nextSibling
        );
      } else {
        this.uiComponentManagement.componentsTable.insertBefore(
          newRow,
          closestElement
        );
      }
    } else {
      this.uiComponentManagement.componentsTable.appendChild(newRow);
    }

    this.updateComponentOrder();
  }

  /**
   * Updates the order of components in the components table and stores it in the componentsOrderInput.
   *
   * This function retrieves the current order of components from the components table,
   * constructs an array of objects containing component IDs and instance IDs, and then
   * serializes this array into a JSON string, which is stored in the componentsOrderInput.
   *
   * @returns void
   */
  updateComponentOrder(): void {
    var order = Array.from(
      this.uiComponentManagement.componentsTable.querySelectorAll("li")
    ).map((row) => {
      // TODO: Create an interface for the components order
      const componentOrderData: ComponentOrderData = {
        komponen_id: row.dataset[this.COMPONENT_ELEMENT_DATA_ATTR_ID],
        komponen_instance_id:
          row.dataset[this.COMPONENT_ELEMENT_DATA_ATTR_INSTANCE_ID],
      };
      return componentOrderData;
    });

    this.uiComponentManagement.componentsOrderInput.value =
      JSON.stringify(order);
  }

  initializeEventHandlers() {
    const tabelKomponen = this.uiComponentManagement.componentsTable;

    // Delegate click events for edit and delete
    tabelKomponen.addEventListener("click", (event) => {
      const target = event.target as HTMLElement;

      if (!target) return;

      if (target.closest(this.editComponentSelector)) {
        this.editKomponen(event);
      } else if (target.closest(this.deleteComponentSelector)) {
        this.deleteKomponen(event);
      }
    });

    // Handle double-click on list items
    tabelKomponen.addEventListener("dblclick", (e) => {
      // console.log("componentManager.initializeEventHandlers().function(e: MouseEvent): invoked");
      const target = e.target as HTMLElement;

      if (!target) return;

      const liElement = target.closest("li");

      if (!liElement) return;

      // Mandatory component parameters
      const componentId =
        liElement.dataset[this.COMPONENT_ELEMENT_DATA_ATTR_ID];
      const componentName =
        liElement.dataset[this.COMPONENT_ELEMENT_DATA_ATTR_NAME];
      const komponenInstanceId =
        liElement.dataset[this.COMPONENT_ELEMENT_DATA_ATTR_INSTANCE_ID];

      if (!componentId || !componentName || !komponenInstanceId) return; // Return if mandatory parameter is missing

      this.openEditKomponenMetaModal(componentId, komponenInstanceId);
    });
  }

  // Function to handle component editing
  editKomponen(event: MouseEvent) {
    // console.log("ComponenManager.editKomponen(): invoked");

    const button = (event.target as HTMLElement).closest(
      this.editComponentSelector
    );
    const liElement = button?.closest("li");

    if (!liElement) return;

    // Mandatory component parameters
    const komponenId = liElement.getDataAttribute(
      this.COMPONENT_ELEMENT_DATA_ATTR_ID
    );
    const komponenNama = liElement.getDataAttribute(
      this.COMPONENT_ELEMENT_DATA_ATTR_NAME
    );
    const komponenInstanceId = liElement.getDataAttribute(
      this.COMPONENT_ELEMENT_DATA_ATTR_INSTANCE_ID
    );

    // console.log(
    //   `ComponenManager.editKomponen(): ${komponenId} | ${komponenNama} | ${komponenInstanceId}`
    // );

    if (!komponenId || !komponenNama || !komponenInstanceId) return; // Return if mandatory parameter is missing

    this.openEditKomponenMetaModal(komponenId, komponenInstanceId);
  }

  // Function to handle component deletion
  deleteKomponen(event: MouseEvent) {
    const button = (event.target as HTMLElement)?.closest(
      this.deleteComponentSelector
    );
    const liElement = button?.closest("li");

    if (!liElement) {
      return;
    }

    Swal.fire({
      title: i18next.t("delete_item"),
      text: i18next.t("deleted_item_cannot_be_recovered"),
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "var(--mdb-danger)",
      confirmButtonText: i18next.t("delete"),
      cancelButtonText: i18next.t("cancel"),
    }).then((result) => {
      if (result.isConfirmed) {
        // Remove the component from the DOM
        liElement.remove();

        // Update the component order
        this.updateComponentOrder();

        // Show placeholder if no components remain
        const tabelKomponen = this.uiComponentManagement.componentsTable;
        if (tabelKomponen.querySelectorAll("li").length === 0) {
          const noComponentsRow = document.createElement("li");
          noComponentsRow.classList.add(
            "list-group-item",
            this.noComponentSelector.slice(1),
            "text-center"
          );
          noComponentsRow.innerHTML =
            "No components added yet. Drag and drop to add.";
          tabelKomponen.appendChild(noComponentsRow);
        }
      }
    });
  }

  openEditKomponenMetaModal(componentId: string, componentInstanceId: string) {
    const component = getComponentDataById(
      this.availableComponents,
      componentId
    );
    // console.log("componentManager.openEditKomponenMetaModal()");
    // console.log(component);

    if (!component) return;

    // Prepare editComponentMetaModalUI
    const editComponentMetaModalUI: UiEditComponenMetaModal = {
      modalElement: document.getElementById(
        "editKomponenMetaModal"
      ) as HTMLElement,
      label: document.getElementById("editMetaModalLabel") as HTMLElement,
      formElement: document.getElementById(
        "editKomponenMetaForm"
      ) as HTMLFormElement,
      inputContainer: document.getElementById("input-container") as HTMLElement,
      nextMetaButton: document.getElementById(
        "nextMetaButton"
      ) as HTMLButtonElement,
      prevMetaButton: document.getElementById(
        "previousMetaButton"
      ) as HTMLButtonElement,
      clearMetaHistoryButton: document.getElementById(
        "clearMetaHistoryButton"
      ) as HTMLButtonElement,
      spinner: document.getElementById("editMetaModalSpinner") as HTMLElement,
      metaIndex: document.getElementById("metaDataIndex") as HTMLElement,
      metaCount: document.getElementById("metaDataCount") as HTMLElement,
    };

    // console.log(editComponentMetaModalUI);

    // Prepare componentMetaData
    const componentMetaData: ComponentMetaData = {
      componentData: component,
      instanceId: componentInstanceId,
      pageId: this.pageId.toString(),
      componentId: componentId,
      meta: null,
    };

    // Open edit modal
    this.editModal.open(editComponentMetaModalUI, componentMetaData);
  }
}
