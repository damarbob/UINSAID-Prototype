// Fungsi multifungsi untuk pemrosesan kuantitas
function processBulkNew(dataTable, actionUrl, options, columnsToSend = null) {
  // Default options
  var defaultOptions = {
    title: "Test",
    confirmMessage: "Test",
    errorMessage: "Test",
    type: "warning",
    confirmButtonText: "Test",
    cancelButtonText: "Test",
  };

  // Merge default options with provided options
  options = Object.assign({}, defaultOptions, options);

  var selectedRows = dataTable.rows({ selected: true }).data().toArray();

  // Show confirmation dialog
  Swal.fire({
    title: options.title,
    text: options.confirmMessage,
    icon: options.type,
    showCancelButton: true,
    confirmButtonText: options.confirmButtonText,
    cancelButtonText: options.cancelButtonText,
    confirmButtonColor: "var(--mdb-primary)",
    focusCancel: true,
  }).then((result) => {
    if (result.isConfirmed) {
      if (selectedRows.length > 0) {
        // If columnsToSend is specified, only send those columns, otherwise send all data
        var selectedData = selectedRows.map(function (row) {
          if (columnsToSend) {
            // Send only specified columns
            let data = {};
            columnsToSend.forEach((column) => {
              data[column] = row[column];
            });
            return data;
          } else {
            // Send entire row data
            return row;
          }
        });

        console.log(selectedData);

        $.ajax({
          url: actionUrl,
          type: "POST",
          data: { selectedData: selectedData },
          success: function (response) {
            dataTable.ajax.reload(); // Reload data

            // Show success alert dialog
            Swal.fire({
              position: "top-end",
              icon: "success",
              title: response.message,
              showConfirmButton: false,
              timer: 1500,
            });
          },
          error: function (error) {
            // TODO: Translation
            // Show error alert dialog
            var errorMessage = error.responseJSON
              ? error.responseJSON.message
              : "Terjadi galat dalam proses";

            Swal.fire({
              position: "top-end",
              icon: "error",
              title: options.title,
              text: errorMessage,
            });

            // Handle the error response from the server
            console.error(error);
          },
        });
      } else {
        // Show error alert dialog if no rows are selected
        Swal.fire({
          title: options.title,
          text: options.errorMessage,
          icon: "error",
        });
      }
    }
  });
}
