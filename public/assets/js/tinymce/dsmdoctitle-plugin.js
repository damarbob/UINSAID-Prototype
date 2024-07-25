tinymce.PluginManager.add("dsmdoctitle", function (editor) {
  // Add title input on top of the TinyMCE menubar
  editor.ui.registry.addMenuButton("_dsm_doc_title", {
    text: "Document Title",
    fetch: function (callback) {
      callback([
        {
          type: "input",
          name: "title",
          label: "Title",
          id: "_dsm_doc_title",
          onAction: function () {
            // When title changes, copy it to the specified input ID
            var titleInputId = editor.settings.title_input_id;
            var title = this.value();
            if (titleInputId) {
              var targetInput = document.getElementById(titleInputId);
              if (targetInput) {
                targetInput.value = title;
              }
            }
          },
        },
      ]);
    },
  });

  // Register editor option "title_input_id"
  //   editor.ui.registry.addEditorCommand("title_input_id", function (ui, value) {
  //     editor.settings.title_input_id = value;
  //   });
});
