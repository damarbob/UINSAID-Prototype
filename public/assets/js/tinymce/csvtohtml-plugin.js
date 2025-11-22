(function () {
  "use strict";

  const loadSheetJS = (callback) => {
    if (window.XLSX) {
      callback();
      return;
    }
    const script = document.createElement("script");
    // Using a stable version from CDN
    script.src =
      "https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js";
    script.onload = callback;
    script.onerror = () => {
      console.error("Failed to load SheetJS");
      alert(
        "Failed to load Excel processing library. Please check your internet connection."
      );
    };
    document.head.appendChild(script);
  };

  tinymce.PluginManager.add("csvtohtml", function (editor) {
    const openDialog = () => {
      loadSheetJS(() => {
        let fileInputHtml =
          '<input type="file" accept=".csv, .xlsx, .xls" id="csvtohtml-file-input" style="width: 100%; margin-top: 5px; padding: 5px; border: 1px solid #ccc; border-radius: 4px;">';

        editor.windowManager.open({
          title: "Insert CSV/Excel as Table",
          body: {
            type: "panel",
            items: [
              {
                type: "htmlpanel",
                html:
                  "<div><label>Upload File (CSV, Excel)</label>" +
                  fileInputHtml +
                  "</div>",
              },
              {
                type: "textarea",
                name: "csvData",
                label: "Or Paste CSV Data Here",
                placeholder: "Name, Age, City\nAlice, 30, New York",
              },
              {
                type: "checkbox",
                name: "hasHeader",
                label: "First row is header",
                checked: true,
              },
            ],
          },
          buttons: [
            {
              type: "cancel",
              text: "Cancel",
            },
            {
              type: "submit",
              text: "Insert",
              primary: true,
            },
          ],
          onSubmit: function (api) {
            const data = api.getData();
            const fileInput = document.getElementById("csvtohtml-file-input");

            if (fileInput && fileInput.files.length > 0) {
              const file = fileInput.files[0];
              const reader = new FileReader();

              reader.onload = function (e) {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: "array" });
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];
                const html = XLSX.utils.sheet_to_html(worksheet, {
                  id: "excel-table",
                  editable: false,
                });

                // Clean up the generated HTML a bit if needed, or just insert
                // SheetJS generates a full HTML page sometimes, we need just the table
                // Actually sheet_to_html returns a table string usually.
                // Let's verify if it returns full html. It usually returns a table.
                // But it might include <html><body> tags if not configured?
                // No, sheet_to_html returns a string with <table>...</table> usually.
                // Let's strip potential outer tags just in case or just insert.

                // However, sheet_to_html might not respect "Has Header" styling directly,
                // but it gives a good starting point.
                // If we want to respect "Has Header" strictly for styling, we might need to parse to JSON first.

                processAndInsert(worksheet, api.getData().hasHeader);
                api.close();
              };
              reader.readAsArrayBuffer(file);
            } else if (data.csvData) {
              // Parse CSV from text area
              const workbook = XLSX.read(data.csvData, { type: "string" });
              const firstSheetName = workbook.SheetNames[0];
              const worksheet = workbook.Sheets[firstSheetName];
              processAndInsert(worksheet, data.hasHeader);
              api.close();
            } else {
              editor.notificationManager.open({
                text: "Please upload a file or paste CSV data.",
                type: "error",
              });
            }
          },
        });
      });
    };

    const processAndInsert = (worksheet, hasHeader) => {
      // Convert to JSON to have more control over HTML generation if needed,
      // or use sheet_to_html and post-process.
      // Let's use sheet_to_json to get data and build table manually for better TinyMCE integration (styling)

      const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 }); // header:1 gives array of arrays

      if (!jsonData || jsonData.length === 0) return;

      let html =
        '<table style="border-collapse: collapse; width: 100%;" border="1">';

      jsonData.forEach((row, index) => {
        if (index === 0 && hasHeader) {
          html += "<thead><tr>";
          row.forEach((cell) => {
            html += `<th style="padding: 8px; background-color: #f2f2f2;">${escapeHtml(
              cell
            )}</th>`;
          });
          html += "</tr></thead><tbody>";
        } else {
          if (index === 0 && !hasHeader) html += "<tbody>";

          html += "<tr>";
          row.forEach((cell) => {
            html += `<td style="padding: 8px;">${escapeHtml(cell)}</td>`;
          });
          html += "</tr>";
        }
      });

      html += "</tbody></table>";
      editor.insertContent(html);
    };

    const escapeHtml = (text) => {
      if (text === null || text === undefined) return "";
      return String(text)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
    };

    editor.ui.registry.addButton("csvtohtml", {
      icon: "table",
      text: "CSV/Excel",
      tooltip: "Insert CSV or Excel as Table",
      onAction: openDialog,
    });

    editor.ui.registry.addMenuItem("csvtohtml", {
      icon: "table",
      text: "Insert CSV/Excel as Table",
      onAction: openDialog,
    });

    return {
      getMetadata: () => ({
        name: "DSM CSV/Excel Import",
        url: "https://dsm.my.id/",
      }),
    };
  });
})();
