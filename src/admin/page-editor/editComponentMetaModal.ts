// editComponentMetaModal.ts

// @ts-ignore
import * as mdb from "mdb-ui-kit"; // Material Design
import Swal from "sweetalert2"; // For confirmation dialogs
import { config } from "../../config";
import MetaInputCreator from "./metaInputCreator";
import {
  destroyTinyMCEInstances,
  extractMetaFieldFromContent,
} from "./use-case/componentManagementUseCase";
import ComponentMetaData from "./interface/componentMetaData";
import UiEditComponenMetaModal from "./interface/uiEditComponentMetaModal";
import MetaFieldPopulator from "./metaFieldPopulator";
import i18next from "i18next";

export default class EditComponenMetaModal {
  private handleSubmitEvent!: (event: Event) => void; // Store the event listener reference

  // Constants
  private FORM_DATA_NAME_META = "meta";
  private FORM_DATA_NAME_INSTANCE_ID = "instance_id";
  private FORM_DATA_NAME_COMPONENT_ID = "komponen_id";
  private FORM_DATA_NAME_PAGE_ID = "halaman_id";

  // Parameters
  private editComponentMetaModalUI!: UiEditComponenMetaModal;
  private componentMetaData!: ComponentMetaData;
  private metaDataIndex!: number;

  /**
   * Initializes the modal UI and logic.
   */
  public open(
    editComponentMetaModalUI: UiEditComponenMetaModal,
    componentMetaData: ComponentMetaData,
    metaDataIndex: number = 0
  ): void {
    this.editComponentMetaModalUI = editComponentMetaModalUI;
    this.componentMetaData = componentMetaData;
    this.metaDataIndex = metaDataIndex;
    this.initializeUI();
    this.initializeModal();
    this.fetchAndPopulateMetaData();
  }

  public reload(
    editComponentMetaModalUI: UiEditComponenMetaModal,
    componentMetaData: ComponentMetaData,
    metaDataIndex: number = 0
  ) {
    this.editComponentMetaModalUI = editComponentMetaModalUI;
    this.componentMetaData = componentMetaData;
    this.metaDataIndex = metaDataIndex;
    this.fetchAndPopulateMetaData();
  }

  /**
   * Initializes the UI elements of the modal.
   */
  private initializeUI(): void {
    // Disable buttons
    this.disableButtons();

    // Set initial UI state
    this.setMetaIndexAndCount(0, 0);
    this.showSpinner();
    this.setModalLabel(this.componentMetaData.componentData.name);
  }

  /**
   * Initializes the modal instance and event listeners.
   */
  private initializeModal(): void {
    const modalInstance =
      mdb.Modal.getInstance(this.editComponentMetaModalUI.modalElement) ||
      new mdb.Modal(this.editComponentMetaModalUI.modalElement, {
        focus: false,
      });

    if (
      !this.editComponentMetaModalUI.modalElement.classList.contains("show")
    ) {
      modalInstance.show();
    }

    this.attachModalEventListeners();
  }

  /**
   * Attaches event listeners to the modal.
   */
  private attachModalEventListeners(): void {
    // Clean up TinyMCE instances when modal is hidden
    this.editComponentMetaModalUI.modalElement.addEventListener(
      "hidden.mdb.modal",
      () => {
        destroyTinyMCEInstances(
          this.editComponentMetaModalUI.modalElement.querySelectorAll(
            "textarea"
          )
        );
      }
    );

    // Clean up event listener
    this.editComponentMetaModalUI.modalElement.removeEventListener(
      "submit",
      this.handleSubmitEvent
    );

    // Attach submit handler
    this.handleSubmitEvent = (event: Event): void => {
      this.handleSubmit(event);
    };
    this.editComponentMetaModalUI.modalElement.addEventListener(
      "submit",
      this.handleSubmitEvent
    );
    // console.log('attachModalEventListeners(): Event listener attached.');
  }

  /**
   * Handles the modal form submission.
   */
  private handleSubmit(event: Event): void {
    event.preventDefault();
    // console.log(this.componentMetaData.pageId);
    // Encode form data from the inputs
    const formData = new FormData();
    // return;

    // Retrieve necessary component and page details from modal dataset
    const componentId = this.componentMetaData.componentData.id;
    const componentInstanceId = this.componentMetaData.instanceId;
    const halamanId: string = this.componentMetaData.pageId.toString();

    // Append meta, componentId, instanceId, and halamanId to the FormData
    formData.appendEncodedFormMetaInputs(
      this.FORM_DATA_NAME_META,
      this.editComponentMetaModalUI.formElement
    ); // Customized FormData.prototype.append
    formData.append(this.FORM_DATA_NAME_INSTANCE_ID, componentInstanceId);
    formData.append(this.FORM_DATA_NAME_COMPONENT_ID, componentId);
    formData.append(this.FORM_DATA_NAME_PAGE_ID, halamanId);

    // formData.forEach((value, key) => {
    //   console.log("key: " + key + ", value: " + value);
    // });

    // Send formData to the server
    fetch(`${config.baseUrl}admin/komponen/simpan/meta`, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          // If successful
          Swal.fire(i18next.t("success"), data.message, "success"); // Show success message

          this.reload(this.editComponentMetaModalUI, this.componentMetaData); // Reload the modal with the updated data
        } else {
          // If error
          Swal.fire(i18next.t("error"), data.message, "error"); // Show error message
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        Swal.fire(
          i18next.t("error"),
          i18next.t("error_occured_during_processing"),
          "error"
        );
      });
  }

  /**
   * Fetches and populates meta data into the modal.
   */
  private fetchAndPopulateMetaData(): void {
    $.ajax({
      url: `${config.baseUrl}api/syntax/process-data-syntax`,
      type: "POST",
      data: { content: this.componentMetaData.componentData.meta },
      success: (response: any) => {
        // If content not found, there might be a problem with the component data retrieval
        if (!this.componentMetaData.componentData.content) {
          console.error(
            `Component ${this.componentMetaData.componentData.name} has no content!`
          );
          return;
        }

        // console.log(response);

        this.handleMetaDataResponse(
          response,
          this.componentMetaData.componentData.content
        );
      },
      error: (xhr: any, status: any, error: any) =>
        console.error("ERROR:", status),
    });
  }

  /**
   * Handles the meta data response from the server.
   */
  private handleMetaDataResponse(response: any, content: string): void {
    if (response.data) {
      const metaField = JSON.parse(response.data);
      this.processMetaField(metaField, content);
      // console.log('Processing meta field...');
    } else {
      console.error("Component meta data is not found!");
    }
  }

  /**
   * Processes the meta field and creates input fields.
   */
  private processMetaField(metaField: any, content: string): void {
    if (metaField && metaField.length > 0) {
      this.createInputsFromKomponenMetaV2(metaField);
    } else {
      const extractedMeta = extractMetaFieldFromContent(content);
      this.createInputsFromKomponenMeta(extractedMeta);
    }

    if (metaField.length === 0) {
      this.hideSpinner();
      return;
    }

    this.fetchExistingMetaData();
  }

  /**
   * Fetches existing meta data for the component.
   */
  private fetchExistingMetaData(): void {
    $.ajax({
      url: `${config.baseUrl}api/komponen/meta`,
      type: "POST",
      data: {
        idInstance: this.componentMetaData.instanceId,
        idKomponen: this.componentMetaData.componentData.id,
        idHalaman: this.componentMetaData.pageId,
        index: this.metaDataIndex,
      },
      success: (response) => this.handleExistingMetaResponse(response),
      error: (xhr, status, error) => console.error("ERROR:", status),
    });
  }

  /**
   * Handles the existing meta data response.
   */
  private handleExistingMetaResponse(response: any): void {
    // console.log(response);
    this.hideSpinner();
    this.enableSaveButton();

    if (response.data) {
      const meta = JSON.parse(response.data.meta);
      const metaDataIndexNew = parseInt(response.index);
      const metaDataCountNew = parseInt(response.count);

      this.setMetaIndexAndCount(metaDataIndexNew + 1, metaDataCountNew);
      this.setupNavigationListeners(metaDataIndexNew, metaDataCountNew);

      const metaFieldPopulator = new MetaFieldPopulator(
        this.editComponentMetaModalUI.modalElement
      );
      metaFieldPopulator.populateEditKomponenMetaFields(meta);

      // this.populateEditKomponenMetaFields(meta); /// Deprecated
    }
  }

  /**
   * Sets up navigation listeners for next/previous buttons.
   */
  private setupNavigationListeners(
    currentIndex: number,
    totalCount: number
  ): void {
    const nextMetaIndex = currentIndex + 1;
    const previousMetaIndex = currentIndex - 1;

    this.editComponentMetaModalUI.nextMetaButton.onclick = () => {
      this.reload(
        this.editComponentMetaModalUI,
        this.componentMetaData,
        previousMetaIndex
      ); // Reload the modal with the updated data
    };

    this.editComponentMetaModalUI.prevMetaButton.onclick = () => {
      this.reload(
        this.editComponentMetaModalUI,
        this.componentMetaData,
        nextMetaIndex
      ); // Reload the modal with the updated data
    };

    this.editComponentMetaModalUI.clearMetaHistoryButton.onclick = () => {
      this.confirmClearMetaHistory();
    };

    if (currentIndex <= 0) {
      // Hide meta button
      this.editComponentMetaModalUI.nextMetaButton.disabled = true;
      // console.log("metaCount: " + metaDataCountNew);
      if (totalCount > 1) {
        this.editComponentMetaModalUI.prevMetaButton.disabled = false;
      } else {
        this.editComponentMetaModalUI.prevMetaButton.disabled = true;
      }
    } else if (currentIndex + 1 >= totalCount) {
      // Enable next meta button
      this.editComponentMetaModalUI.nextMetaButton.disabled = false;
      this.editComponentMetaModalUI.prevMetaButton.disabled = true;
    } else {
      // Enable previous meta button
      this.editComponentMetaModalUI.nextMetaButton.disabled = false;
      this.editComponentMetaModalUI.prevMetaButton.disabled = false;
    }

    if (totalCount <= 1) {
      this.editComponentMetaModalUI.clearMetaHistoryButton.disabled = true;
    } else {
      this.editComponentMetaModalUI.clearMetaHistoryButton.disabled = false;
    }
  }

  /**
   * Confirms and clears meta history.
   */
  private confirmClearMetaHistory(): void {
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
        this.clearMetaHistory();
      }
    });
  }

  /**
   * Clears meta history via AJAX.
   */
  private clearMetaHistory(): void {
    $.ajax({
      url: `${config.baseUrl}api/komponen/meta/hapus-riwayat`,
      type: "POST",
      data: {
        idInstance: this.componentMetaData.instanceId,
        idKomponen: this.componentMetaData.componentData.id,
        idHalaman: this.componentMetaData.pageId,
      },
      success: (response) => {
        if (response.status === "success") {
          Swal.fire(
            i18next.t("success"),
            i18next.t("meta_data_cleaned_successfully"),
            "success"
          );
          //   this.openEditKomponenMetaModal(0);
        } else {
          Swal.fire(
            i18next.t("error"),
            i18next.t("failed_to_clean_meta_data"),
            "error"
          );
        }
      },
      error: (xhr, status, error) => console.error("ERROR:", status),
    });
  }

  // Helper methods
  private disableButtons(): void {
    this.editComponentMetaModalUI.nextMetaButton.disabled = true;
    this.editComponentMetaModalUI.prevMetaButton.disabled = true;
    this.editComponentMetaModalUI.clearMetaHistoryButton.disabled = true;
  }

  private setMetaIndexAndCount(index: number, count: number): void {
    this.editComponentMetaModalUI.metaIndex.innerHTML = index.toString();
    this.editComponentMetaModalUI.metaCount.innerHTML = count.toString();
  }

  private showSpinner(): void {
    this.editComponentMetaModalUI.spinner.style.display = "inline-block";
  }

  private hideSpinner(): void {
    this.editComponentMetaModalUI.spinner.style.display = "none";
  }

  private setModalLabel(label: string): void {
    this.editComponentMetaModalUI.label.innerHTML = label;
  }

  private enableSaveButton(): void {
    this.editComponentMetaModalUI.nextMetaButton.disabled = false;
  }

  private createInputsFromKomponenMetaV2(metaField: any): void {
    const metaInputCreator = new MetaInputCreator(
      this.editComponentMetaModalUI.inputContainer
    );
    metaInputCreator.createInputsFromKomponenMetaV2(metaField);
  }

  private createInputsFromKomponenMeta(metaField: any): void {
    const metaInputCreator = new MetaInputCreator(
      this.editComponentMetaModalUI.inputContainer
    );
    metaInputCreator.createInputsFromKomponenMeta(metaField);
  }
}
