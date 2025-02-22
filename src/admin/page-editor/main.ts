// main.ts

import { config } from "../../config";
import ComponentSearch from "./componentSearch";
import ComponentManager from "./componentManager";
import ComponentData from "./interface/componentData";
import i18next from "i18next";
import { id } from "./translation/id";
import { en } from "./translation/en";

document.addEventListener("DOMContentLoaded", function () {
  // console.log(config.baseUrl);

  // Set translation
  i18next.init({
    lng: window.lang,
    debug: true,
    resources: {
      id: id,
      en: en,
    },
  });

  $.ajax({
    url: `${config.baseUrl}api/komponen/semua`,
    type: "POST",
    success: (response) => {
      // console.log(response);
      if (!response.data) return; // Add Swal and an option to refresh page

      const availableComponents: Array<ComponentData> = [];
      response.data.forEach((component: any) => {
        availableComponents.push({
          id: component.id,
          name: component.nama,
          content: component.konten,
          meta: component.meta,
          singular: component.tunggal,
        });
      });

      // console.log(availableComponents);

      new ComponentManager(
        Number(document.getElementById("idHalaman")?.textContent ?? 0),
        availableComponents,
        {
          loader: document.getElementById("loaderBody") as HTMLElement,
          componentsTable: document.getElementById(
            "tabelKomponen"
          ) as HTMLUListElement,
          availableComponentsList: document.getElementById(
            "daftarKomponen"
          ) as HTMLUListElement,
          componentsOrderInput: document.querySelector(
            'input[name="id_komponen"]'
          ) as HTMLInputElement,
        }
      );
    },
    error: (xhr, status, error) => console.error("ERROR:", status),
  });

  new ComponentSearch(
    document.getElementById("searchKomponen") as HTMLInputElement
  );

  // initializeEventHandlers();
});
