// eventHandlers.js

/**
 * @deprecated use componentManager.ts instead
 */
export function initializeEventHandlers(updateKomponenOrder) {
  const tabelKomponen = document.getElementById("tabelKomponen");

  // Delegate click events for edit and delete
  tabelKomponen.addEventListener("click", function (event) {
    if (event.target.closest(".edit-komponen")) {
      editKomponen(event);
    } else if (event.target.closest(".remove-komponen")) {
      deleteKomponen(event, updateKomponenOrder);
    }
  });

  // Handle double-click on list items
  tabelKomponen.addEventListener("dblclick", function (e) {
    const liElement = e.target.closest("li");
    if (liElement) {
      const componentId = liElement.dataset.id;
      const componentName = liElement.dataset.name;
      const komponenInstanceId = liElement.dataset.instanceId;

      const metaDataIndex = 0; // Replace with actual meta data index

      openEditKomponenMetaModal(
        componentId,
        componentName,
        komponenInstanceId,
        metaDataIndex
      );
    }
  });
}

// Function to handle component editing
function editKomponen(event) {
  const button = event.target.closest(".edit-komponen");
  const liElement = button.closest("li");
  const komponenId = liElement.getAttribute("data-id");
  const komponenNama = liElement.getAttribute("data-name");
  const komponenInstanceId = liElement.getAttribute("data-instance-id");

  const metaDataIndex = document.getElementById("metaDataIndex").innerHTML;

  openEditKomponenMetaModal(
    komponenId,
    komponenNama,
    komponenInstanceId,
    metaDataIndex
  );
}

// Function to handle component deletion
function deleteKomponen(event, updateKomponenOrder) {
  const button = event.target.closest(".remove-komponen");
  const liElement = button.closest("li");

  Swal.fire({
    title: "Delete Item",
    text: "Deleted items cannot be recovered.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "var(--mdb-danger)",
    confirmButtonText: "Delete",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      // Remove the component from the DOM
      liElement.remove();

      // Update the component order
      updateKomponenOrder();

      // Show placeholder if no components remain
      const tabelKomponen = document.getElementById("tabelKomponen");
      if (tabelKomponen.querySelectorAll("li").length === 0) {
        const noComponentsRow = document.createElement("li");
        noComponentsRow.classList.add(
          "list-group-item",
          "no-components",
          "text-center"
        );
        noComponentsRow.innerHTML =
          "No components added yet. Drag and drop to add.";
        tabelKomponen.appendChild(noComponentsRow);
      }
    }
  });
}

function openEditKomponenMetaModal(
  componentId,
  componentName,
  componentInstanceId,
  metaDataIndex
) {
  // console.log("start: " + metaDataIndex);

  /* Initialize UI */
  document.getElementById("nextMetaButton").disabled = true;
  document.getElementById("previousMetaButton").disabled = true;
  document.getElementById("clearMetaHistoryButton").disabled = true;

  document.getElementById("metaDataIndex").innerHTML = 0; // Show meta index
  document.getElementById("metaDataCount").innerHTML = 0; // Show meta count

  document.getElementById("editMetaModalSpinner").style.display =
    "inline-block"; // Show edit modal spinner
  document.getElementById("editMetaModalLabel").innerHTML = componentName;
  /* End of UI initialization */

  /* Initialize modal */
  const modalElement = document.getElementById("editKomponenMetaModal");
  let modalInstance = mdb.Modal.getInstance(modalElement); // Check if modal instance already exists

  if (!modalInstance) {
    modalInstance = new mdb.Modal(modalElement, {
      focus: false, // Disable focus trapping for tinyMCE modal inputs to work properly
    });
  }

  if (!modalElement.classList.contains("show")) {
    modalInstance.show(); // Only show the modal if it's not already shown
  }

  // Remove tinyMCE instances
  modalElement.addEventListener("hidden.mdb.modal", function () {
    // Find all elements inside the modal and destroy TinyMCE instances
    modalElement.querySelectorAll("textarea").forEach((element) => {
      if (tinymce.get(element.id)) {
        // Check if the element has a TinyMCE instance
        tinymce.get(element.id).remove(); // Destroy the TinyMCE instance
      }
    });
  });

  /////

  // Initialize view
  document.getElementById("saveKomponenMetaButton").disabled = true; // Disable save button

  // Save componentId in a data attribute so handleSubmit can access it
  modalElement.dataset.componentId = componentId;
  modalElement.dataset.componentInstanceId = componentInstanceId;

  // console.log(modalElement.dataset.componentId);
  // console.log(modalElement.dataset.componentInstanceId);

  const componentList =
    "<?php echo addcslashes(json_encode($daftarKomponen), '\"'); ?>"; // Contains all of the available components

  const content = getKomponenKontenById(componentList, componentId);
  const newMeta = getKomponenMetaById(componentList, componentId); // New version meta

  // console.log(JSON.parse(meta.length));
  console.log(newMeta);

  // Process data syntax from meta
  $.ajax({
    url: "??api/syntax/process-data-syntax??",
    type: "POST",
    data: {
      content: newMeta,
    },
    success: function (response) {
      // If data exists, populate to meta input fields
      if (response["data"]) {
        const meta = response["data"];
        let metaField = JSON.parse(meta);

        console.log(metaField.length); // If meta is an array, it will return undefined

        //////////////////////

        // If new version meta is available, handle it. Otherwise, lookup old version meta in the content.
        // The metaField length will be 0 if new version meta unavailable
        if (metaField && metaField.length > 0) {
          createInputsFromKomponenMetaV2(metaField); //  Create input fields for editing metadata

          // If komponen has no meta syntax, exit
          if (metaField.length === 0) {
            // Update UI
            document.getElementById("editMetaModalSpinner").style.display =
              "none"; // Hide edit modal spinner
            return;
          }
        } else {
          metaField = extractMetaFieldFromContent(content); // Extract meta field from content

          createInputsFromKomponenMeta(metaField); //  Create input fields for editing metadata

          // If komponen has no meta syntax, exit
          if (metaField.length === 0) {
            // Update UI
            document.getElementById("editMetaModalSpinner").style.display =
              "none"; // Hide edit modal spinner
            return;
          }
        }

        // Old meta

        // If komponen has meta syntax, get existing meta if any
        // AJAX get existing meta for the selected component
        $.ajax({
          url: "??api/komponen/meta??",
          type: "POST",
          data: {
            idInstance: componentInstanceId,
            idKomponen: componentId,
            idHalaman: "??halaman_id??",
            index: parseInt(metaDataIndex),
          },
          success: function (response) {
            // Update UI
            document.getElementById("editMetaModalSpinner").style.display =
              "none"; // Hide edit modal spinner
            document.getElementById("saveKomponenMetaButton").disabled = false; // Enable save button

            // If data exists, populate to meta input fields
            if (response["data"]) {
              const responseMeta = response["data"]["meta"]; // Get the component's meta

              // console.log(responseMeta);

              if (responseMeta) {
                const meta = JSON.parse(responseMeta); // Deserialize responseMeta
                var metaDataIndexNew = parseInt(response["index"]);
                var metaDataCountNew = parseInt(response["count"]);
                const nextMetaIndex = metaDataIndexNew + 1;
                const previousMetaIndex = metaDataIndexNew - 1;

                /* Listeners */
                const nextMeta = function () {
                  // modalInstance.hide(); // Hide the modal
                  openEditKomponenMetaModal(
                    componentId,
                    componentName,
                    componentInstanceId,
                    nextMetaIndex
                  );

                  // console.log("end: " + (nextMetaIndex));
                };
                const prevMeta = function () {
                  // modalInstance.hide(); // Hide the modal
                  openEditKomponenMetaModal(
                    componentId,
                    componentName,
                    componentInstanceId,
                    previousMetaIndex
                  );
                };

                // Set listener to previous button
                document.getElementById("previousMetaButton").onclick =
                  nextMeta;

                // Set listener to next button
                document.getElementById("nextMetaButton").onclick = prevMeta;
                document.getElementById("clearMetaHistoryButton").onclick =
                  function () {
                    // Confirm delete
                    Swal.fire({
                      title: "<?= lang('Admin.hapusItem') ?>",
                      text: "<?= lang('Admin.itemYangTerhapusTidakDapatKembali') ?>",
                      icon: "warning",
                      showCancelButton: true,
                      confirmButtonColor: "var(--mdb-danger)",
                      confirmButtonText: "<?= lang('Admin.hapus') ?>",
                      cancelButtonText: "<?= lang('Admin.batal') ?>",
                    }).then((result) => {
                      if (result.isConfirmed) {
                        // Send request to clear metadata history
                        $.ajax({
                          url: "??api/komponen/meta/hapus-riwayat??",
                          type: "POST",
                          data: {
                            idInstance: componentInstanceId,
                            idKomponen: componentId,
                            idHalaman: "??halaman_id??",
                          },
                          success: function (response) {
                            const status = response["status"];
                            console.log(response);

                            if (status) {
                              if (status === "success") {
                                // If successful, show success message and load first meta

                                // Show success message
                                Swal.fire(
                                  "??Admin.sukses??",
                                  "??Admin.dataMetaBerhasilDibersihkan??",
                                  "success"
                                );

                                // Load first meta
                                openEditKomponenMetaModal(
                                  componentId,
                                  componentName,
                                  componentInstanceId,
                                  0
                                );
                              } else {
                                // Show error message
                                Swal.fire(
                                  "??Admin.galat??",
                                  "??Admin.tidakDapatMembersihkanDataMeta??",
                                  "error"
                                );
                              }
                            }
                          },
                          error: function (xhr, status, error) {
                            console.log("ERROR:" + status);
                          },
                          complete: function () {
                            // Any additional actions on completion
                          },
                        });
                      }
                    });
                  };

                /* End of listeners */

                // console.log("response: " + metaDataIndexNew + "| next: " + nextMetaIndex + " | prev: " + previousMetaIndex);

                populateEditKomponenMetaFields(meta); // Populate the inputs with retreived meta

                document.getElementById("metaDataIndex").innerHTML =
                  metaDataIndexNew + 1; // Show meta index
                document.getElementById("metaDataCount").innerHTML =
                  metaDataCountNew; // Show meta count

                if (metaDataIndexNew <= 0) {
                  // Hide meta button
                  document.getElementById("nextMetaButton").disabled = true;
                  // console.log("metaCount: " + metaDataCountNew);
                  if (metaDataCountNew > 1) {
                    document.getElementById(
                      "previousMetaButton"
                    ).disabled = false;
                  } else {
                    document.getElementById(
                      "previousMetaButton"
                    ).disabled = true;
                  }
                } else if (metaDataIndexNew + 1 >= metaDataCountNew) {
                  // Enable next meta button
                  document.getElementById("nextMetaButton").disabled = false;
                  document.getElementById("previousMetaButton").disabled = true;
                } else {
                  // Enable previous meta button
                  document.getElementById("nextMetaButton").disabled = false;
                  document.getElementById(
                    "previousMetaButton"
                  ).disabled = false;
                }

                if (metaDataCountNew <= 1) {
                  document.getElementById(
                    "clearMetaHistoryButton"
                  ).disabled = true;
                } else {
                  document.getElementById(
                    "clearMetaHistoryButton"
                  ).disabled = false;
                }
              } else {
                // The komponen meta record is found but meta field is null
                // console.log('Component meta field is null');
              }
            } else {
              // The komponen meta record is not found
              // console.log('Component meta data is not found');
            }
            // console.log(response);
          },
          error: function (xhr, status, error) {
            console.log("ERROR:" + status);
          },
          complete: function () {
            // Any additional actions on completion
          },
        });

        /////////////////////
      } else {
        // The komponen meta record is not found
        // console.log('Component meta data is not found');
      }
      // console.log(response);
    },
    error: function (xhr, status, error) {
      console.log("ERROR:" + status);
    },
    complete: function () {
      // Any additional actions on completion
    },
  });

  // Remove previous event listener before attaching a new one
  document
    .getElementById("editKomponenMetaModal")
    .removeEventListener("submit", handleEditKomponenMetaModalSubmit);
  document
    .getElementById("editKomponenMetaModal")
    .addEventListener("submit", handleEditKomponenMetaModalSubmit);
}
