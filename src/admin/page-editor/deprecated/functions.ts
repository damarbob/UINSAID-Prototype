import Swal from "sweetalert2";
import { getFilenameAndExtension } from "../../use-case/formattingUseCase";
import { reinitializeMDBElements } from "../../use-case/mdbUseCase";

/**
   * 
   * @deprecated use MetaFieldPopulator instead
   */
function populateEditKomponenMetaFields(meta: any) {
    // console.log("Populating component meta:");
    // console.log(meta);

    meta.forEach((item: any) => {
      const id = item["id"];
      let element =
        document.getElementById(id) || document.getElementsByName(id);

      console.log(element);

      // console.log(item.id + ` consists of ${element.length !== undefined ? element.length : '1'} element(s) of ` + element);

      if (element) {
        let value = item["value"];

        // If the element is an object NodeList
        if (NodeList.prototype.isPrototypeOf(element)) {
          console.log('NodeList');
          // console.log('//////////');
          // console.log(item.id + " confirmed a " + element);

          const nodeListElement = element as NodeList;

          let finalElement =
            nodeListElement.length > 0
              ? nodeListElement
              : document.getElementsByName(id + "[]");

          finalElement.forEach(function (selection: any) {
            // console.log(selection);

            if (!Array.isArray(value) && selection.value === value) {
              selection.checked = true;
            } else {
              if (Array.isArray(value)) {
                value.forEach(function (x) {
                  if (selection.value === x) {
                    selection.checked = true;
                  }
                });
              }
            }
          });

          // console.log('//////////');
        } else if (element instanceof HTMLInputElement && element.type) {
          console.log('Input');
          // console.log(element.type);

          // ELEMENT TYPE MEANS THE HTML ELEMENT TYPE AND NOT THE META TIPE
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
              element.checked = value === "on";
              break;
            case "file":
              // Handle multiple files

              // Check whether the value is array, maybe due to user just changed the data type into files
              if (!Array.isArray(value)) {
                if (!value) {
                  // If falsy value, return
                  return;
                }
                value = [value]; // Convert it into array if it's not
              }

              // console.log(value);

              // We cannot do anything to file input including changing the text
              // Instead, we store the previously uploaded file to a hidden input 'old'
              const filesInputOld = document.getElementById(
                id + "_old"
              ) as HTMLInputElement;
              const filesFormHelper = document.getElementById(
                id + "_formHelper"
              ) as HTMLDivElement;
              const filesInputParent = document.getElementById(
                id + "_parent"
              ) as HTMLInputElement;

              if (filesInputOld) {
                filesInputOld.value = JSON.stringify(value); // This will result in array even with a single value JUST DON'T FORGET TO PARSE BEFORE STRINGIFYING AGAIN, OTHERWISE BROKEN
              }

              // Show all files
              value.forEach((fileUrl: string) => {
                // console.log('File URL:', fileUrl);

                filesFormHelper.insertAdjacentHTML(
                  "beforeend",
                  `
                      <small>
                          (
                          <a href="<?= base_url() ?>${fileUrl}" target="_blank">
                              ${getFilenameAndExtension(fileUrl)}
                              <i class="bi bi-box-arrow-up-right ms-2"></i>
                          </a>
                          )
                      </small>
                  `
                );
              });

              // Delete button alongside with its script to empty the input old
              // Append the button to the parent
              filesInputParent.insertAdjacentHTML(
                "beforeend",
                `
                <button type="button" class="btn btn-danger btn-sm btn-floating" id="${id}_buttonHapusFile" data-mdb-ripple-init="">
                    <i class="bi bi-trash"></i>
                </button>
                `
              );

              // Get reference to the button after it's added
              const buttonHapusFile = document.getElementById(
                `${id}_buttonHapusFile`
              );

              // Add the event listener
              buttonHapusFile?.addEventListener("click", function () {
                // Confirm delete
                Swal.fire({
                  title: "<?= lang('Admin.hapusItem') ?>",
                  text: "<?= lang('Admin.itemYangTerhapusTidakDapatKembali') ?>",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "var(--mdb-danger)",
                  confirmButtonText: "<?= lang('Admin.hapus') ?>",
                  cancelButtonText: "<?= lang('Admin.batal') ?>",
                }).then((result: any) => {
                  if (result.isConfirmed) {
                    // Set input value to empty and hide delete button
                    filesInputOld.value = "";
                    filesFormHelper.style.display = "none";
                    buttonHapusFile.style.display = "none";

                    console.log(filesFormHelper);
                  }
                });
              });
              // }

              break;
            case "select-one":
              element.value = value;
              break;
            default:
              if (element.tagName === "TEXTAREA") {
                element.value = value;
              } else {
                element.innerHTML = value;
              }
              break;
          }
        }
      } else {
        console.log(`Element with ID or Name ${id} not found.`);
      }
    });

    // reinitializeMDBElements(this.editComponentMetaModalUI.inputContainer); // Update MDB elements
  }