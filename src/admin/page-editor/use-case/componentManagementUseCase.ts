// componentManagementUseCase.ts

import tinymce from "tinymce";
import ComponentData from "../interface/componentData";
import { config } from "../../../config";
import { isValidJSON } from "../../use-case/jsonUseCase";

/**
 * Function to get a component from the component data array based on a given 'id'.
 *
 * @param {string} componentData - The array of component data.
 * @param {string} id - The id of the component to retrieve.
 * @returns {string|null} - The component with the given id, or null if not found.
 */
export function getComponentDataById(
  componentData: ComponentData[],
  id: string
): ComponentData | null {
  try {
    // Find the component with the matching id
    const component = componentData.filter((item) => item.id === id)[0];

    // Return the 'konten' if found, otherwise null
    return component ? component : null;
  } catch (error) {
    console.error("Error parsing JSON or finding component:", error);
    return null;
  }
}

export function extractMetaFieldFromContent(content: string): any {
  console.warn(
    "The component uses old meta syntax. Consider migrating to new meta syntax."
  );
  // console.log(content);

  // Regular expression to match meta comments
  const regex = /\/\*\s*meta\s*({.*?})\s*meta\s*\*\//g;
  let matches;
  const metaDataArray = [];

  // Loop to find all matches
  while ((matches = regex.exec(content)) !== null) {
    try {
      // Parse the matched JSON string into an object
      const metaObject = JSON.parse(matches[1]);
      metaDataArray.push(metaObject);
    } catch (error) {
      console.error("Error parsing meta JSON:", error);
    }
  }

  // console.log(metaDataArray);

  return metaDataArray;
}

/**
 * Initializes TinyMCE for an editor input field.
 * @param id - The ID of the textarea element.
 */
export function initializeTinyMCE(id: string): void {
  // console.log("Initializing TinyMCE for:", id);

  if (tinymce.get(id)) {
    tinymce.get(id)?.remove(); // Destroy existing instance
  }

  setTimeout(() => {
    tinymce.init({
      selector: `#${id}`,
      license_key: "gpl",
      external_plugins: {
        dsmgallery: `${config.baseUrl}assets/js/tinymce/dsmgallery-plugin.js`,
        dsmfileinsert: `${config.baseUrl}assets/js/tinymce/dsmfileinsert-plugin.js`,
      },
      dsmgallery_api_endpoint: `${config.baseUrl}api/galeri`,
      dsmgallery_gallery_url: `${config.baseUrl}admin/galeri`,
      dsmfileinsert_api_endpoint: `${config.baseUrl}api/file`,
      dsmfileinsert_file_manager_url: `${config.baseUrl}admin/file`,
      plugins: [
        "advlist",
        "autolink",
        "image",
        "lists",
        "link",
        "charmap",
        "preview",
        "anchor",
        "searchreplace",
        "fullscreen",
        "insertdatetime",
        "table",
        "help",
        "wordcount",
        "dsmgallery",
        "dsmfileinsert",
        "code",
      ],
      toolbar:
        "fullscreen | dsmgallery dsmfileinsert | undo redo | casechange blocks | bold italic backcolor | image | " +
        "alignleft aligncenter alignright alignjustify | " +
        "bullist numlist checklist outdent indent | removeformat | table | code | help",
      promotion: false,
    });
  }, 500);
}

export function destroyTinyMCEInstances(
  editors: NodeListOf<HTMLElement>
): void {
  editors.forEach((element) => {
    if (tinymce.get(element.id)) {
      tinymce.get(element.id)?.remove();
    }
  });
}

// Utility function to get dataset value
function getDataAttribute(element: HTMLElement, attr: string) {
  return element.dataset[attr];
}

// Utility function to select element
function selectElementByDataAttr(attr: string, value: string) {
  const selector = "data-" + attr.replace(/([A-Z])/g, "-$1").toLowerCase();
  return document.querySelector(`[${selector}="${value}"]`);
}

Element.prototype.getDataAttribute = function (attr: string): string | null {
  const selector = "data-" + attr.replace(/([A-Z])/g, "-$1").toLowerCase();
  return this.getAttribute(selector);
};

// Implementing the single element selector
Element.prototype.getElementByDataAttr = function (
  attr: string,
  value: string
): Element | null {
  const selector = `[data-${attr
    .replace(/([A-Z])/g, "-$1")
    .toLowerCase()}="${value}"]`;
  return this.querySelector(selector);
};

// Implementing the multiple elements selector
Element.prototype.getElementsByDataAttr = function (
  attr: string,
  value: string
): NodeListOf<Element> {
  const selector = `[data-${attr
    .replace(/([A-Z])/g, "-$1")
    .toLowerCase()}="${value}"]`;
  return this.querySelectorAll(selector);
};

FormData.prototype.appendEncodedFormMetaInputs = function (
  name: string = "meta",
  form: HTMLFormElement
): void {
  const inputs = form.querySelectorAll("input, textarea, select") as NodeListOf<
    HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement
  >;
  let meta: { id: string; value: any }[] = [];
  let formData = this;
  let processedNames = new Set<string>(); // To keep track of processed radio button groups

  inputs.forEach((input) => {
    const {
      id,
      type,
      name,
      value,
      files: inputFiles,
      checked,
    } = input as HTMLInputElement;
    // console.log(id + " | " + name);

    if (!id) return; // Skip inputs without IDs

    // Handle file inputs
    if (type === "file") {
      const inputElement = input as HTMLInputElement;

      if (inputElement.hasAttribute("multiple")) {
        // Handle multiple files

        if (inputFiles && inputFiles.length > 0) {
          for (let i = 0; i < inputFiles.length; i++) {
            formData.append(name, inputFiles[i]); // Append files as an array (name should include '[]')
            // console.log(`id: ${id} | name: ${name}`);
          }
          const fileArray = Array.from(inputFiles).map((file) => file.name); // Collect file names for meta
          meta.push({
            id,
            value: fileArray,
          });
        } else {
          const oldFiles = (
            document.getElementById(id + "_old") as HTMLInputElement
          ).value;

          meta.push({
            id,
            value: isValidJSON(oldFiles) ? JSON.parse(oldFiles) : "", // MUST BE PARSED BACK TO JS OBJECT BECAUSE ALL META WILL BE STRINGIFIED IN THE END. TO PREVENT DOUBLE STRINGIFICATION!
          });
        }
      } else {
        // Handle single file

        if (inputFiles && inputFiles.length > 0) {
          formData.append(name, inputFiles[0]); // Append file to formData to enable upload
          const fileArray = Array.from(inputFiles).map((file) => file.name); // Collect file names for meta
          meta.push({
            id,
            value: fileArray,
          });
          // console.log(inputFiles);
          // console.log(inputFiles[0]);
        } else {
          const oldFiles = (
            document.getElementById(id + "_old") as HTMLInputElement
          ).value;

          meta.push({
            id,
            value: isValidJSON(oldFiles) ? JSON.parse(oldFiles) : "", // MUST BE PARSED BACK TO JS OBJECT BECAUSE ALL META WILL BE STRINGIFIED IN THE END. TO PREVENT DOUBLE STRINGIFICATION!
          });
        }
      }
    }
    // Handle radio buttons - only add the checked one, avoid duplicates
    else if (type === "radio") {
      if (checked && !processedNames.has(name)) {
        meta.push({
          id: name,
          value,
        }); // Use name to group radio buttons
        processedNames.add(name);
      }
    }
    // Handle checkboxes
    else if (type === "checkbox") {
      // Check if it is "multiple checkboxes". OR in meta, the "tipe" is "checkboxes".
      if (name.endsWith("[]")) {
        // console.log("It is multiple checkboxes");

        // If unchecked, return.
        if (!checked) {
          return;
        }

        let originalName = name.slice(0, -2); // Original name without the "[]"

        // Find if an object with the same id already exists
        let existingItem = meta.find((item) => item.id === originalName);

        if (existingItem) {
          // If the value property is already an array, append the new value
          if (Array.isArray(existingItem.value)) {
            existingItem.value.push(value);
          } else {
            // If it's not an array, convert it into an array and add the new value
            existingItem.value = [existingItem.value, value];
          }
        } else {
          // If the id does not exist, add a new object to meta
          meta.push({
            id: originalName,
            value: value,
          });
        }
      } else {
        meta.push({
          id: id,
          value: checked ? "on" : "off",
        });
      }
    }
    // Handle hidden input, normally do nothing as there'll be no hidden input for UX
    else if (type === "hidden") {
      // Do nothing
    }
    // Handle all other inputs
    else {
      meta.push({
        id,
        value,
      });
    }
  });

  // console.log(meta); // Log all meta

  // Add the encoded JSON to FormData for sending to the server
  formData.append(name, JSON.stringify(meta));

  // console.log(formData); // Log formData

  // return formData;
};
