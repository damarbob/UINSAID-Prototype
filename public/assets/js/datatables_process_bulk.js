// Fungsi multifungsi untuk pemrosesan kuantitas
function processBulk(dataTable, actionUrl, options) {
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
        var selectedIds = selectedRows.map(function (row) {
          return row["id"]; // Put ID to the map
        });

        $.ajax({
          url: actionUrl,
          type: "POST",
          data: { selectedIds: selectedIds },
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
