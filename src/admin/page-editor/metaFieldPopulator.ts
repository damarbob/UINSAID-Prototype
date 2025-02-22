// metaFieldPopulator.ts

import Swal from "sweetalert2"; // For confirmation dialogs
import { reinitializeMDBElements } from "../use-case/mdbUseCase";
import i18next from "i18next";
import { config } from "../../config";
import { getFilenameAndExtension } from "../use-case/formattingUseCase";

export default class MetaFieldPopulator {
  private modalElement: HTMLElement;

  constructor(modalElement: HTMLElement) {
    this.modalElement = modalElement;
  }

  /**
   * Populates form fields with meta data.
   * @param this.modalElement - The modal element containing the form fields.
   * @param meta - Array of meta data objects.
   */
  public populateEditKomponenMetaFields(meta: any[]): void {
    meta.forEach((item) => {
      const id = item.id;
      const element =
        this.modalElement.querySelector(`#${id}`) ||
        this.modalElement.querySelectorAll(`[name="${id}"]`);

      if (element) {
        this.populateElement(element, item);
      } else {
        console.error(`Element with ID or Name ${id} not found.`);
      }
    });

    reinitializeMDBElements(this.modalElement); // Update MDB elements
  }

  /**
   * Populates a single form element with meta data.
   * @param this.modalElement - The modal element containing the form fields.
   * @param element - The HTML element or NodeList to populate.
   * @param item - The meta data item.
   */
  private populateElement(element: Element | NodeList, item: any): void {
    const id = item.id;
    let value = item.value;
    // console.log(element);

    if (element instanceof NodeList) {
      let finalElement =
        element.length > 0 ? element : document.getElementsByName(id + "[]");
      this.populateNodeList(finalElement, value);
      // console.log('NodeList');
    } else if (
      element instanceof HTMLInputElement ||
      element instanceof HTMLSelectElement ||
      element instanceof HTMLTextAreaElement
    ) {
      this.populateInputElement(element, id, value);
      // console.log('Input');
    } else {
      console.error(`Unsupported element type for ID: ${id}`);
    }
  }

  /**
   * Populates a NodeList of elements (e.g., checkboxes, radios).
   * @param nodeList - The NodeList of elements.
   * @param value - The value(s) to populate.
   */
  private populateNodeList(nodeList: NodeList, value: any): void {
    nodeList.forEach((element: any) => {
      if (!Array.isArray(value) && element.value === value) {
        element.checked = true;
      } else if (Array.isArray(value)) {
        value.forEach((x) => {
          if (element.value === x) {
            element.checked = true;
          }
        });
      }
    });
  }

  /**
   * Populates an input element with meta data.
   * @param this.modalElement - The modal element containing the form fields.
   * @param element - The input element to populate.
   * @param id - The ID of the element.
   * @param value - The value to populate.
   */
  private populateInputElement(
    element: HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement,
    id: string,
    value: any
  ): void {
    switch (element.type) {
      case "text":
      case "email":
      case "password":
      case "number":
      case "color":
      case "range":
      case "datetime-local":
        element.value = value;
        break;
      case "checkbox":
        (element as HTMLInputElement).checked = value === "on";
        break;
      case "file":
        this.handleFileInput(element as HTMLInputElement, id, value);
        break;
      case "select-one":
        (element as HTMLSelectElement).value = value;
        break;
      default:
        if (element.tagName === "TEXTAREA") {
          (element as HTMLTextAreaElement).value = value;
        } else {
          element.innerHTML = value;
        }
        break;
    }
  }

  /**
   * Handles file input fields and displays previously uploaded files.
   * @param this.modalElement - The modal element containing the form fields.
   * @param element - The file input element.
   * @param id - The ID of the file input.
   * @param value - The file value(s).
   */
  private handleFileInput(
    element: HTMLInputElement,
    id: string,
    value: any
  ): void {
    if (!Array.isArray(value)) {
      if (!value) return; // Skip if value is falsy
      value = [value]; // Convert to array
    }

    const filesInputOld = this.modalElement.querySelector(
      `#${id}_old`
    ) as HTMLInputElement;
    const filesFormHelper = this.modalElement.querySelector(
      `#${id}_formHelper`
    ) as HTMLDivElement;
    const filesInputParent = this.modalElement.querySelector(
      `#${id}_parent`
    ) as HTMLElement;

    if (filesInputOld && filesFormHelper && filesInputParent) {
      filesInputOld.value = JSON.stringify(value); // Store file URLs

      // Display file links
      value.forEach((fileUrl: string) => {
        filesFormHelper.insertAdjacentHTML(
          "beforeend",
          `<small>
              (
              <a href="${config.baseUrl + fileUrl}" target="_blank">
                ${getFilenameAndExtension(fileUrl)}
                <i class="bi bi-box-arrow-up-right ms-2"></i>
              </a>
              )
            </small>`
        );
      });

      // Add delete button
      filesInputParent.insertAdjacentHTML(
        "beforeend",
        `<button type="button" class="btn btn-danger btn-sm btn-floating" id="${id}_buttonHapusFile" data-mdb-ripple-init>
            <i class="bi bi-trash"></i>
          </button>`
      );

      const buttonHapusFile = this.modalElement.querySelector(
        `#${id}_buttonHapusFile`
      );
      buttonHapusFile?.addEventListener("click", () =>
        this.confirmDeleteFile(
          filesInputOld,
          filesFormHelper,
          buttonHapusFile as HTMLElement
        )
      );
    }
  }

  /**
   * Confirms and deletes a file.
   * @param filesInputOld - The hidden input storing file URLs.
   * @param filesFormHelper - The helper element displaying file links.
   * @param buttonHapusFile - The delete button.
   */
  private confirmDeleteFile(
    filesInputOld: HTMLInputElement,
    filesFormHelper: HTMLElement,
    buttonHapusFile: HTMLElement
  ): void {
    Swal.fire({
      title: i18next.t("delete_item"),
      text: i18next.t("deleted_item_cannot_be_recovered"),
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "var(--mdb-danger)",
      confirmButtonText: i18next.t("delete"),
      cancelButtonText: i18next.t("cancel"),
    }).then((result: any) => {
      if (result.isConfirmed) {
        filesInputOld.value = "";
        filesFormHelper.style.display = "none";
        buttonHapusFile.style.display = "none";
      }
    });
  }
}

// Usage
//   const this.modalElement = document.getElementById('editKomponenMetaModal') as HTMLElement;
//   const metaFieldPopulator = new MetaFieldPopulator();
//   metaFieldPopulator.populateEditKomponenMetaFields(this.modalElement, metaDataArray);
