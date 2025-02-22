// metaInputCreator.ts

import { replaceEnvironmentSyntax } from "../use-case/environmentSyntaxParser";
import i18next from "i18next";
import { reinitializeMDBElements } from "../use-case/mdbUseCase";
import { initializeTinyMCE } from "./use-case/componentManagementUseCase";

export default class MetaInputCreator {
  private container: HTMLElement;

  // Selector
  private requireMetaSelector: string = ".require-meta";

  constructor(container: HTMLElement) {
    this.container = container;
    if (!this.container) {
      throw new Error(`Container not found.`);
    }
  }

  /**
   * Creates input fields from meta data (V2 format).
   * @param meta - Array of meta data objects.
   */
  public createInputsFromKomponenMetaV2(meta: any[]): void {
    this.clearContainer();

    if (meta.length === 0) {
      this.displayNoMetaMessage();
      this.toggleMetaRequiredElements(false);
      return;
    }

    this.toggleMetaRequiredElements(true);
    meta.forEach((item) => this.createInputFromMetaItem(item));
    reinitializeMDBElements(this.container);
  }

  /**
   * Creates input fields from meta data (legacy format).
   * @param meta - Array of meta data objects.
   */
  public createInputsFromKomponenMeta(meta: any[]): void {
    // console.log(meta);

    this.clearContainer();

    if (meta.length === 0) {
      this.displayNoMetaMessage();
      this.toggleMetaRequiredElements(false);
      return;
    }

    this.toggleMetaRequiredElements(true);
    meta.forEach((item) =>
      this.createInputFromMetaItem({
        content: item, // Use content key for new format
      })
    );
    reinitializeMDBElements(this.container);
  }

  /**
   * Clears the container before adding new inputs.
   */
  private clearContainer(): void {
    this.container.innerHTML = "";
  }

  /**
   * Displays a message when no meta data is available.
   */
  private displayNoMetaMessage(): void {
    this.container.insertAdjacentHTML(
      "beforeend",
      `<p>${i18next.t("component_does_not_have_meta_field")}</p>`
    );
  }

  /**
   * Toggles the visibility of elements that require meta data (such as meta history).
   * @param show - Whether to show or hide the elements.
   */
  private toggleMetaRequiredElements(show: boolean): void {
    document.querySelectorAll(this.requireMetaSelector).forEach((element) => {
      if (show) {
        element.classList.remove("d-none");
      } else {
        element.classList.add("d-none");
      }
    });
  }

  /**
   * Creates an input field from a meta data item.
   * @param item - Meta data item.
   */
  private createInputFromMetaItem(item: any): void {
    if (!item.content || item.content === null) {
      console.error("Invalid meta content");
      return;
    }

    const { id, nama, tipe, keterangan, options, required, value, checked } =
      item.content;
    const inputHTML = this.generateInputHTML(
      id,
      nama,
      tipe,
      keterangan,
      options,
      required,
      value,
      checked
    );

    this.container.insertAdjacentHTML("beforeend", inputHTML);

    if (tipe === "editor") {
      initializeTinyMCE(id);
      // console.log("Initialized TinyMCE for editor input with ID:", id);
    }
  }

  /**
   * Generates HTML for an input field based on its type.
   */
  private generateInputHTML(
    id: string,
    nama: string,
    tipe: string,
    keterangan: string,
    options: any[] | any,
    required: boolean,
    value: string,
    checked: boolean
  ): string {
    const requiredAttr = required ? "required" : "";
    const valueAttr = value ? value : "";
    const keteranganHTML = keterangan
      ? `<div class="form-helper"><small>${replaceEnvironmentSyntax(
          keterangan
        )}</small></div>`
      : "";

    switch (tipe) {
      case "text":
      case "email":
      case "password":
      case "number":
        return `
          <div class="form-outline ${
            keterangan ? "mb-4" : "mb-3"
          }" data-mdb-input-init>
            <input type="${tipe}" id="${id}" name="${id}" value="${valueAttr}" class="form-control" ${requiredAttr} />
            <label class="form-label" for="${id}">${nama}</label>
            ${keteranganHTML}
          </div>`;

      case "datetime-local":
        return `
          <div class="form-outline ${
            keterangan ? "mb-4" : "mb-3"
          }" data-mdb-input-init>
            <input type="${tipe}" id="${id}" name="${id}" value="${valueAttr}" class="form-control form-control-lg" ${requiredAttr} />
            <label class="form-label" for="${id}">${nama}</label>
            ${keteranganHTML}
          </div>`;

      case "color":
        return `
          <div class="${keterangan ? "mb-4" : "mb-3"}">
            <label class="form-label" for="${id}">${nama}</label>
            <input type="${tipe}" id="${id}" name="${id}" value="${valueAttr}" class="form-control form-control-color" title="${nama}" />
            ${keteranganHTML}
          </div>`;

      case "textarea":
        return `
          <div class="form-outline ${
            keterangan ? "mb-4" : "mb-3"
          }" data-mdb-input-init>
            <textarea id="${id}" name="${id}" class="form-control" ${requiredAttr}>${valueAttr}</textarea>
            <label class="form-label" for="${id}">${nama}</label>
            ${keteranganHTML}
          </div>`;

      case "editor":
        return `
          <div class="${keterangan ? "mb-4" : "mb-3"}" data-mdb-input-init>
            <label class="form-label" for="${id}">${nama}</label>
            <textarea id="${id}" name="${id}" class="form-control">${valueAttr}</textarea>
            ${keteranganHTML}
          </div>`;

      case "checkbox":
        return `
          <div class="form-check ${keterangan ? "mb-4" : "mb-3"}">
            <input type="checkbox" id="${id}" name="${id}" class="form-check-input" ${requiredAttr} ${
          checked ? "checked" : ""
        } />
            <label class="form-check-label" for="${id}">${nama}</label>
            ${keteranganHTML}
          </div>`;

      case "checkboxes":
        if (options && Array.isArray(options)) {
          return options
            .map(
              (option) => `
            <div class="form-check mb-3">
              <input type="checkbox" id="${id}_${
                option.value
              }" name="${id}[]" value="${
                option.value
              }" class="form-check-input" ${requiredAttr} ${
                option.checked ? "checked" : ""
              } />
              <label class="form-check-label" for="${id}_${option.value}">${
                option.label || option.value
              }</label>
            </div>`
            )
            .join("");
        }
        break;

      case "radio":
        if (options && Array.isArray(options)) {
          return options
            .map(
              (option) => `
            <div class="form-check mb-3">
              <input type="radio" id="${id}_${
                option.value
              }" name="${id}" value="${
                option.value
              }" class="form-check-input" ${requiredAttr} ${
                option.checked ? "checked" : ""
              } />
              <label class="form-check-label" for="${id}_${option.value}">${
                option.label
              }</label>
            </div>`
            )
            .join("");
        }
        break;

      case "range":
        if (!Array.isArray(options)) return "";
        const minAttr = options[0]?.max ? `min="${options[0].min}"` : "";
        const maxAttr = options[0]?.max ? `max="${options[0].max}"` : "";
        return `
          <label class="form-label" for="${id}">${nama}</label>
          <div class="range mb-3">
            <input type="range" id="${id}" name="${id}" value="${valueAttr}" class="form-range" ${minAttr} ${maxAttr} />
          </div>`;

      case "file":
      case "file-multiple":
        const isMultiple = tipe === "file-multiple" ? "multiple" : "";
        return `
          <div class="form-floating mb-3" id="${id}_parent">
            <input type="file" id="${id}" name="${id}${
          isMultiple ? "[]" : ""
        }" class="form-control" ${isMultiple} />
            <label class="form-label" for="${id}">${nama}</label>
            <div class="form-helper" id="${id}_formHelper">
              <!-- Filled dynamically -->
            </div>
            <input type="hidden" id="${id}_old" name="${id}" />
          </div>`;

      case "select":
        if (options && Array.isArray(options)) {
          const optionsHTML = options
            .map(
              (option) =>
                `<option value="${option.value}" ${
                  option.value === true ? "selected" : ""
                }>${option.label}</option>`
            )
            .join("");
          return `
            <div class="mb-3">
              <label class="form-label" for="${id}">${nama}</label>
              <select id="${id}" name="${id}" class="form-select">
                ${optionsHTML}
              </select>
            </div>`;
        }
        break;

      default:
        console.warn(`Unknown input type: ${tipe}`);
        return "";
    }
    return "";
  }
}

// Usage
// const metaInputCreator = new MetaInputCreator("input-container");
// metaInputCreator.createInputsFromKomponenMetaV2(metaDataArray);
